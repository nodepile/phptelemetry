<?php

namespace NodePile\PHPTelemetry\Contracts;

interface DriverInterface
{
	/**
	 * Log the given message & context.
	 * 
	 * @param string $level
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function write(): void;
}