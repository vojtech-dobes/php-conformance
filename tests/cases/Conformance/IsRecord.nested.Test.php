<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


$constraint = new Vojtechdobes\Conformance\Constraints\IsRecord(
	requiredFields: [
		'a' => new Vojtechdobes\Conformance\Constraints\IsRecord(
			requiredFields: [
				'b' => new Vojtechdobes\Conformance\Constraints\IsIdenticalTo('B'),
			],
			ignoreExtraFields: false,
		),
	],
);

assertConstraintErrors($constraint, ['a' => ['b' => 'B']], []);

assertConstraintErrors($constraint, ['a' => ['b' => true]], [
	new Vojtechdobes\Conformance\Error(
		"Value isn't correct",
		[
			'expectedValue' => 'B',
			'path' => ['a', 'b'],
		],
	),
]);

assertConstraintErrors($constraint, ['a' => ['b' => 'B', 'c' => true]], [
	new Vojtechdobes\Conformance\Error(
		"Record can't have any unknown fields",
		[
			'unknownFields' => ['c'],
			'path' => ['a'],
		],
	),
]);
