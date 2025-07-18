<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @template TPreValue
 * @template TOr
 * @implements Conformance\Constraint<TPreValue, TOr>
 */
final class BooleanAtLeastOne implements Conformance\Constraint
{

	/**
	 * @param array<Conformance\Constraint<TPreValue, TOr>> $constraints
	 */
	public function __construct(
		private readonly array $constraints,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		$errors = [];

		foreach ($this->constraints as $key => $constraint) {
			$constraintResult = $constraint->validate($value, $resultFactory);

			if ($constraintResult->errors === []) {
				return $resultFactory->pass()->withValue($constraintResult->value);
			}

			$errors[$key] = $constraintResult->errors;
		}

		return $resultFactory->fail([
			new Conformance\Error(
				'At least one constraint must be pass',
				[
					'errors' => $errors,
				],
			),
		]);
	}

}
