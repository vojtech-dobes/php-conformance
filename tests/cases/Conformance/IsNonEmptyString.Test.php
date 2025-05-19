<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


$constraint = new Vojtechdobes\Conformance\Constraints\IsNonEmptyString();

assertConstraintErrors($constraint, 'A', []);
assertConstraintErrors($constraint, 'Abc', []);

assertConstraintErrors($constraint, true, [
	new Vojtechdobes\Conformance\Error(
		'Value must be a string',
	),
]);

assertConstraintErrors($constraint, '', [
	new Vojtechdobes\Conformance\Error(
		"String can't be empty",
	),
]);
