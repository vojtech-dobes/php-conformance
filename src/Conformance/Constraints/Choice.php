<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @template TAllowedValue of scalar
 * @implements Conformance\Constraint<mixed, TAllowedValue>
 */
final class Choice implements Conformance\Constraint
{

	/**
	 * @param non-empty-array<TAllowedValue> $allowedValues
	 */
	public function __construct(
		private readonly array $allowedValues,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if (in_array($value, $this->allowedValues, true)) {
			return $resultFactory->pass();
		}

		return $resultFactory->fail([
			new Conformance\Error(
				'Value must be one of allowed values',
				[
					'allowedValues' => $this->allowedValues,
				],
			),
		]);
	}

}
