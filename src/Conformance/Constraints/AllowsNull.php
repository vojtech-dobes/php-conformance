<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @template TInnerPreValue
 * @template TInnerPostValue
 * @implements Conformance\Constraint<TInnerPreValue, TInnerPostValue|null>
 */
final class AllowsNull implements Conformance\Constraint
{

	/**
	 * @param Conformance\Constraint<TInnerPreValue, TInnerPostValue> $constraint
	 */
	public function __construct(
		private readonly Conformance\Constraint $constraint,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if ($value === null) {
			return $resultFactory->pass();
		}

		return $this->constraint->validate($value, $resultFactory);
	}

}
