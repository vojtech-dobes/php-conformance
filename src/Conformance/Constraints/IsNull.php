<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @implements Conformance\Constraint<mixed, null>
 */
final class IsNull implements Conformance\Constraint
{

	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if ($value !== null) {
			return $resultFactory->fail([
				new Conformance\Error(
					'Value must be null',
				),
			]);
		}

		return $resultFactory->pass();
	}

}
