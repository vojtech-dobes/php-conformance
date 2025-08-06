<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @template TPreValue
 * @template TAnd
 * @implements Conformance\Constraint<TPreValue, TAnd>
 */
final class BooleanAll implements Conformance\Constraint
{

	/**
	 * @param array<Conformance\Constraint<covariant TPreValue, covariant TAnd>> $constraints
	 */
	public function __construct(
		private readonly array $constraints,
	) {}



	/**
	 * @return Conformance\Result<bool, TPreValue|TAnd>
	 */
	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		$result = $resultFactory->pass();

		foreach ($this->constraints as $constraint) {
			$result = $result->with(
				$constraint->validate($value, $resultFactory),
			);

			$value = $result->value;
		}

		return $result;
	}

}
