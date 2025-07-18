<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @implements Conformance\Constraint<mixed, non-empty-string>
 */
final class IsNonEmptyString implements Conformance\Constraint
{

	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if (is_string($value) === false) {
			return $resultFactory->fail([
				new Conformance\Error(
					'Value must be a string',
				),
			]);
		}

		if ($value === '') {
			return $resultFactory->fail([
				new Conformance\Error(
					"String can't be empty",
				),
			]);
		}

		return $resultFactory->pass();
	}

}
