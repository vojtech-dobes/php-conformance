<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance;


/**
 * @template TPreValue
 * @template TPostValue
 */
interface Constraint
{

	/**
	 * @param TPreValue $value
	 * @param ResultFactory<TPreValue> $resultFactory
	 * @return Result<bool, covariant TPostValue|TPreValue>
	 */
	function validate(mixed $value, ResultFactory $resultFactory): Result;

}
