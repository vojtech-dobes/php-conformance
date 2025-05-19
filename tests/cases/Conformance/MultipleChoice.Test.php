<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


$constraint = new Vojtechdobes\Conformance\Constraints\MultipleChoice(['a', 'b', 'c']);

assertConstraintErrors($constraint, [], []);

assertConstraintErrors($constraint, ['a'], []);
assertConstraintErrors($constraint, ['b'], []);
assertConstraintErrors($constraint, ['c'], []);

assertConstraintErrors($constraint, ['a', 'b'], []);
assertConstraintErrors($constraint, ['a', 'c'], []);
assertConstraintErrors($constraint, ['b', 'c'], []);

assertConstraintErrors($constraint, ['d'], [
	new Vojtechdobes\Conformance\Error(
		'All items must be one of allowed values',
		[
			'allowedValues' => ['a', 'b', 'c'],
			'unknownValues' => ['d'],
		],
	),
]);

assertConstraintErrors($constraint, ['a', 'd'], [
	new Vojtechdobes\Conformance\Error(
		'All items must be one of allowed values',
		[
			'allowedValues' => ['a', 'b', 'c'],
			'unknownValues' => ['d'],
		],
	),
]);

assertConstraintErrors($constraint, ['a', 'd', 'e'], [
	new Vojtechdobes\Conformance\Error(
		'All items must be one of allowed values',
		[
			'allowedValues' => ['a', 'b', 'c'],
			'unknownValues' => ['d', 'e'],
		],
	),
]);
