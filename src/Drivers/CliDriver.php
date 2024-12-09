<?php

namespace NodePile\PHPTelemetry\Drivers;

use NodePile\PHPTelemetry\Contracts\DriverInterface;
use NodePile\PHPTelemetry\Models\Entry;

class CliDriver implements DriverInterface
{
	/**
	 * @param array $settings
	 */
	public function __construct(array $settings = [])
	{

	}

	/**
	 * Output the given log message & context directly to cli.
	 * 
	 * @param Entry $entry
	 * 
	 * @return void
	 */
	public function write(Entry $entry): void 
	{
		printf(
			"[%s][%s] %s %s%s",
			$entry->getTimestamp()->format('Y-m-d H:i:s'),
			$entry->getLevel(),
			$entry->getMessage(),
			json_encode($entry->getContext()),
			PHP_EOL
		);
	}
}