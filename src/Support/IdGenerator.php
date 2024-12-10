<?php

namespace NodePile\PHPTelemetry\Support;

use NodePile\PHPTelemetry\Contracts\IdGeneratorInterface;

class IdGenerator implements IdGeneratorInterface
{
	/**
	 * Generate a unique id.
	 * 
	 * @return string
	 */
	public function generate(): string 
	{
		return uniqid();
	}
}
