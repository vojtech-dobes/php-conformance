<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @template TAllowedValue of scalar
 * @implements Conformance\Constraint<mixed, array<TAllowedValue>>
 */
final class MultipleChoice implements Conformance\Constraint
{

	/**
	 * @param array<TAllowedValue> $allowedValues
	 */
	public function __construct(
		private readonly array $allowedValues,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		$unknownValues = array_diff($value, $this->allowedValues);

		if ($unknownValues === []) {
			return $resultFactory->pass();
		}

		return $resultFactory->fail([
			new Conformance\Error(
				'All items must be one of allowed values',
				[
					'allowedValues' => $this->allowedValues,
					'unknownValues' => array_values($unknownValues),
				],
			),
		]);
	}

}
