<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @template TInnerPreValue
 * @template TInnerPostValue
 * @implements Conformance\Constraint<array<TInnerPreValue>, array<TInnerPostValue>>
 */
final class ForEachItem implements Conformance\Constraint
{

	/**
	 * @param Conformance\Constraint<TInnerPreValue, TInnerPostValue> $constraint
	 */
	public function __construct(
		private readonly Conformance\Constraint $constraint,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		$result = $resultFactory->pass();

		foreach ($value as $i => $item) {
			$itemResult = $this->constraint->validate(
				$item,
				new Conformance\ResultFactory($item),
			);

			$valueCopy = $result->value;
			$valueCopy[$i] = $itemResult->value;

			$result = $result->with(
				$itemResult->withValue($valueCopy)->withErrors(
					array_map(
						static function (Conformance\Error $error) use ($i): Conformance\Error {
							$context = $error->context;

							$context['path'] = array_key_exists('path', $context)
								? [$i, ...$context['path']]
								: [$i];

							return new Conformance\Error(
								$error->message,
								$context,
							);
						},
						$itemResult->errors,
					),
				),
			);
		}

		return $result;
	}

}
