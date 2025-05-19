<?php declare(strict_types=1);

namespace Vojtechdobes\Conformance;


final class Error
{

	/**
	 * @param array<string, mixed> $context
	 */
	public function __construct(
		public readonly string $message,
		public readonly array $context = [],
	) {}



	/**
	 * @return array<string, mixed>
	 */
	public function toArray(): array
	{
		$result = [
			'message' => $this->message,
		];

		if ($this->context !== []) {
			$result['context'] = $this->context;
		}

		return $result;
	}

}
