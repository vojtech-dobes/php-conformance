<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance\Constraints;

use BackedEnum;
use Vojtechdobes\Conformance;


/**
 * @template TEnumClass of string
 * @implements Conformance\Constraint<mixed, new<TEnumClass>>
 */
final class IsBackedEnum implements Conformance\Constraint
{

	/**
	 * @param TEnumClass&class-string<BackedEnum> $enumClass
	 */
	public function __construct(
		private readonly string $enumClass,
	) {}



	public function validate(mixed $value, Conformance\ResultFactory $resultFactory): Conformance\Result
	{
		if (
			!$value instanceof $this->enumClass
			&& (is_int($value) || is_string($value))
		) {
			$value = $this->enumClass::tryFrom($value);
		}

		if (in_array($value, $this->enumClass::cases(), true)) {
			return $resultFactory->pass();
		}

		return $resultFactory->fail([
			new Conformance\Error(
				'Value must be one of allowed values',
				[
					'allowedValues' => array_map(
						static fn ($case) => $case->value,
						$this->enumClass::cases(),
					),
				],
			),
		]);
	}

}
