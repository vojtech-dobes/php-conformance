<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance;

use RuntimeException;


final class InvalidValueException extends RuntimeException
{

	/**
	 * @param list<Error> $errors
	 */
	public function __construct(
		public readonly array $errors,
	)
	{
		parent::__construct();
	}

}
