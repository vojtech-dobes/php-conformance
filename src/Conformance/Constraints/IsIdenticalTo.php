<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @implements Conformance\Constraint<mixed, non-empty-string>
 */
final class IsIdenticalTo implements Conformance\Constraint
{

	public function __construct(
		private readonly mixed $value,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if ($value !== $this->value) {
			return $resultFactory->fail([
				new Conformance\Error(
					"Value isn't correct",
					[
						'expectedValue' => $this->value,
					],
				),
			]);
		}

		return $resultFactory->pass();
	}

}
