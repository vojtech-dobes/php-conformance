<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @template TRequiredFields of array<string, Conformance\Constraint>
 * @template TOptionalFields of array<string, Conformance\Constraint>
 * @template TPostValue of array<string, mixed>
 * @implements Conformance\Constraint<mixed, TPostValue>
 */
final class IsRecord implements Conformance\Constraint
{

	/**
	 * @param TRequiredFields $requiredFields
	 * @param TOptionalFields $optionalFields
	 */
	public function __construct(
		private readonly array $requiredFields = [],
		private readonly array $optionalFields = [],
		private readonly bool $ignoreExtraFields = true,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if (is_array($value) === false) {
			return $resultFactory->fail([
				new Conformance\Error('Value must be an array'),
			]);
		}

		$result = $resultFactory->pass();

		$extraFields = [];
		$missingFields = [];
		$fieldResults = [];

		foreach ($this->requiredFields as $field => $fieldConstraint) {
			if (array_key_exists($field, $value)) {
				$fieldResults[$field] = $fieldConstraint->validate(
					$value[$field],
					new Conformance\ResultFactory($value[$field]),
				);
			} else {
				$missingFields[] = $field;
			}
		}

		if ($this->ignoreExtraFields === false) {
			$extraneousFields = array_filter(
				array_keys($value),
				fn ($field) => (
					array_key_exists($field, $this->requiredFields) === false
					&& array_key_exists($field, $this->optionalFields) === false
				),
			);

			foreach ($extraneousFields as $extraneousField) {
				$extraFields[] = $extraneousField;
			}
		} else {
			$result = $result->withValue(array_diff_key(
				$result->value,
				$this->requiredFields,
				$this->optionalFields,
			));
		}

		foreach ($this->optionalFields as $field => $fieldConstraint) {
			if (array_key_exists($field, $value)) {
				$fieldResults[$field] = $fieldConstraint->validate(
					$value[$field],
					new Conformance\ResultFactory($value[$field]),
				);
			}
		}

		if ($missingFields !== []) {
			$result = $result->with($resultFactory->fail([
				new Conformance\Error(
					'Record must have all required fields',
					[
						'missingFields' => $missingFields,
					],
				),
			]));
		}

		if ($extraFields !== []) {
			$result = $result->with($resultFactory->fail([
				new Conformance\Error(
					"Record can't have any unknown fields",
					[
						'unknownFields' => $extraFields,
					],
				),
			]));
		}

		foreach ($fieldResults as $field => $fieldResult) {
			$valueCopy = $result->value;
			$valueCopy[$field] = $fieldResult->value;

			$result = $result->with(
				$fieldResult->withValue($valueCopy)->withErrors(
					array_map(
						static function (Conformance\Error $error) use ($field): Conformance\Error {
							$context = $error->context;

							$context['path'] = array_key_exists('path', $context)
								? [$field, ...$context['path']]
								: [$field];

							return new Conformance\Error(
								$error->message,
								$context,
							);
						},
						$fieldResult->errors,
					),
				),
			);
		}

		return $result;
	}

}
