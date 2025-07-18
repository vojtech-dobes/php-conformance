<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance;


/**
 * @template TValue
 */
final class ResultFactory
{

	/**
	 * @param TValue $value
	 */
	public function __construct(
		public readonly mixed $value,
	) {}



	/**
	 * @return Result<true, TValue>
	 */
	public function pass(): Result
	{
		return Result::pass($this->value);
	}



	/**
	 * @param non-empty-list<Error> $errors
	 * @return Result<false, TValue>
	 */
	public function fail(array $errors): Result
	{
		return Result::fail($this->value, $errors);
	}

}
