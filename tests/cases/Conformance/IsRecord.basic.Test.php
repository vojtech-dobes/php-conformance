<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


$constraint = new Vojtechdobes\Conformance\Constraints\IsRecord(
	requiredFields: [
		'a' => new Vojtechdobes\Conformance\Constraints\IsIdenticalTo('A'),
	],
	optionalFields: [
		'b' => new Vojtechdobes\Conformance\Constraints\IsIdenticalTo('B'),
	],
);

assertConstraintErrors($constraint, ['a' => 'A'], []);

assertConstraintErrors($constraint, ['a' => 'A', 'c' => true], []);

assertConstraintErrors($constraint, true, [
	new Vojtechdobes\Conformance\Error(
		'Value must be an array',
	),
]);

assertConstraintErrors($constraint, [], [
	new Vojtechdobes\Conformance\Error(
		'Record must have all required fields',
		[
			'missingFields' => ['a'],
		],
	),
]);

assertConstraintErrors($constraint, ['a' => true], [
	new Vojtechdobes\Conformance\Error(
		"Value isn't correct",
		[
			'expectedValue' => 'A',
			'path' => ['a'],
		],
	),
]);

assertConstraintErrors($constraint, ['a' => 'A', 'b' => true], [
	new Vojtechdobes\Conformance\Error(
		"Value isn't correct",
		[
			'expectedValue' => 'B',
			'path' => ['b'],
		],
	),
]);

assertConstraintErrors($constraint, ['b' => true], [
	new Vojtechdobes\Conformance\Error(
		'Record must have all required fields',
		[
			'missingFields' => ['a'],
		],
	),
	new Vojtechdobes\Conformance\Error(
		"Value isn't correct",
		[
			'expectedValue' => 'B',
			'path' => ['b'],
		],
	),
]);
