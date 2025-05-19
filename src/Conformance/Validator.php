<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance;


final class Validator
{

	/**
	 * @template TPreValue
	 * @template TPostValue
	 * @param Constraint<TPreValue, covariant TPostValue> $constraint
	 * @param TPreValue $value
	 * @return TPostValue
	 * @throws InvalidValueException
	 */
	public static function validate(
		Constraint $constraint,
		$value,
	): mixed
	{
		$result = $constraint->validate(
			$value,
			new ResultFactory($value),
		);

		if ($result->isValid === false) {
			throw new InvalidValueException($result->errors);
		}

		return $result->value;
	}

}
