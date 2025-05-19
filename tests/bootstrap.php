<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/constants.php';

Tester\Dumper::$dumpDir = OutputDir;
Tester\Environment::setup();

/**
 * @template TPreValue
 * @param Vojtechdobes\Conformance\Constraint<TPreValue, mixed> $constraint
 * @param TPreValue $value,
 * @param list<Vojtechdobes\Conformance\Error> $expectedErrors
 */
function assertConstraintErrors(
	Vojtechdobes\Conformance\Constraint $constraint,
	mixed $value,
	array $expectedErrors,
): void {
	try {
		Vojtechdobes\Conformance\Validator::validate($constraint, $value);

		$actualErrors = [];
	} catch (Vojtechdobes\Conformance\InvalidValueException $e) {
		$actualErrors = $e->errors;
	}

	Tester\Assert::equal(
		$expectedErrors,
		$actualErrors,
		matchOrder: true,
	);
}
