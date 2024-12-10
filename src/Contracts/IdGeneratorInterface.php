<?php

namespace NodePile\PHPTelemetry\Contracts;

interface IdGeneratorInterface 
{
	/**
	 * Generate a unique id.
	 * 
	 * @return string
	 */
	public function generate(): string;
}