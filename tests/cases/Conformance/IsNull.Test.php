<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


$constraint = new Vojtechdobes\Conformance\Constraints\IsNull();

assertConstraintErrors($constraint, null, []);

assertConstraintErrors($constraint, '', [
	new Vojtechdobes\Conformance\Error(
		'Value must be null',
	),
]);
