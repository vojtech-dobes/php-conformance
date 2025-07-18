<?php declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';


enum Foo: string {

	case A = 'a';
	case B = 'b';
	case C = 'c';

}


$constraint = new Vojtechdobes\Conformance\Constraints\IsBackedEnum(Foo::class);

assertConstraintErrors($constraint, Foo::A, []);
assertConstraintErrors($constraint, Foo::B, []);
assertConstraintErrors($constraint, Foo::C, []);

assertConstraintErrors($constraint, 'd', [
	new Vojtechdobes\Conformance\Error(
		'Value must be one of allowed values',
		[
			'allowedValues' => ['a', 'b', 'c'],
		],
	),
]);
