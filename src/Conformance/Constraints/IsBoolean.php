<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @implements Conformance\Constraint<mixed, bool>
 */
final class IsBoolean implements Conformance\Constraint
{

	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if (is_bool($value) === false) {
			return $resultFactory->fail([
				new Conformance\Error(
					'Value must be a boolean',
				),
			]);
		}

		return $resultFactory->pass();
	}

}
