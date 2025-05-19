<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance;


/**
 * @template-covariant TSuccess of bool
 * @template TValue
 */
final class Result
{

	/**
	 * @param TSuccess $isValid
	 * @param TValue $value
	 * @param list<Error> $errors
	 */
	private function __construct(
		public readonly bool $isValid,
		public readonly mixed $value,
		public readonly array $errors,
	) {}



	/**
	 * @param TValue $value
	 * @return self<true, TValue>
	 */
	public static function pass(mixed $value): self
	{
		return new self(true, $value, []);
	}



	/**
	 * @param TValue $value
	 * @param non-empty-list<Error> $errors
	 * @return self<false, TValue>
	 */
	public static function fail(mixed $value, array $errors): self
	{
		return new self(false, $value, $errors);
	}



	/**
	 * @template TOtherValue
	 * @param self<bool, TOtherValue> $other
	 * @return self<bool, TOtherValue>
	 */
	public function with(self $other): self
	{
		return new self(
			$this->isValid && $other->isValid,
			$other->value,
			[...$this->errors, ...$other->errors],
		);
	}



	/**
	 * @param list<Error> $errors
	 * @return self<TSuccess, TValue>
	 */
	public function withErrors(array $errors): self
	{
		return new self(
			$this->isValid,
			$this->value,
			$errors,
		);
	}



	/**
	 * @param TValue $value
	 * @return self<TSuccess, TValue>
	 */
	public function withValue(mixed $value): self
	{
		return new self(
			$this->isValid,
			$value,
			$this->errors,
		);
	}

}
