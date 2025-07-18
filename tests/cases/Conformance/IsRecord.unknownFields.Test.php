<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


$constraint = new Vojtechdobes\Conformance\Constraints\IsRecord(
	requiredFields: [
		'a' => new Vojtechdobes\Conformance\Constraints\IsIdenticalTo('A'),
	],
	optionalFields: [
		'b' => new Vojtechdobes\Conformance\Constraints\IsIdenticalTo('B'),
	],
	ignoreExtraFields: false,
);

assertConstraintErrors($constraint, ['a' => 'A'], []);

assertConstraintErrors($constraint, ['a' => 'A', 'c' => true], [
	new Vojtechdobes\Conformance\Error(
		"Record can't have any unknown fields",
		[
			'unknownFields' => ['c'],
		],
	),
]);
