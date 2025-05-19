<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use Vojtechdobes\Conformance;


/**
 * @implements Conformance\Constraint<mixed, array<string, mixed>>
 */
final class IsMap implements Conformance\Constraint
{

	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if (is_array($value) === false) {
			return $resultFactory->fail([
				new Conformance\Error('Value must be an array'),
			]);
		}

		$result = Conformance\Result::pass($value);

		foreach (array_keys($value) as $key) {
			if (is_string($key) === false) {
				$result = $result->update($resultFactory->fail([
					new Conformance\Error(
						'Key must be a string',
						[
							'key' => $key,
						],
					),
				]));
			}
		}

		return $result;
	}

}
