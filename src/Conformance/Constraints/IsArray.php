<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @implements Conformance\Constraint<mixed, array<mixed>>
 */
final class IsArray implements Conformance\Constraint
{

	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if (is_array($value)) {
			return $resultFactory->pass();
		}

		return $resultFactory->fail([
			new Conformance\Error(
				'Value must be an array',
			),
		]);
	}

}
