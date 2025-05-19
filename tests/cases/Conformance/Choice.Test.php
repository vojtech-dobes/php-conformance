<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


$constraint = new Vojtechdobes\Conformance\Constraints\Choice(['a', 'b', 'c']);

assertConstraintErrors($constraint, 'a', []);
assertConstraintErrors($constraint, 'b', []);
assertConstraintErrors($constraint, 'c', []);

assertConstraintErrors($constraint, 'd', [
	new Vojtechdobes\Conformance\Error(
		'Value must be one of allowed values',
		[
			'allowedValues' => ['a', 'b', 'c'],
		],
	),
]);
