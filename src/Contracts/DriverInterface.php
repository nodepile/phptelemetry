<?php

namespace NodePile\PHPTelemetry\Contracts;

use NodePile\PHPTelemetry\Models\Entry;

interface DriverInterface
{
	/**
	 * Log the given message & context.
	 * 
	 * @param Entry $entry
	 * 
	 * @return void
	 */
	public function write(Entry $entry): void;
}