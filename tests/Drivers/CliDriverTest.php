<?php

namespace NodePile\PHPTelemetry\Tests\Drivers;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Contracts\DriverInterface;
use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\Drivers\CliDriver;
use NodePile\PHPTelemetry\Models\Entry;

class CliDriverTest extends TestCase 
{
	private DriverInterface $driver;

	protected function setUp(): void
	{
		parent::setUp();

		$this->driver = new CliDriver();
	}

	/**
	 * Test that the output format is as expected
	 */
	public function testWriteOutputFormat()
	{
		$entry = new Entry(new \DateTimeImmutable(), Level::Debug->value, "Something to log.", []);

		$knownOutput = sprintf(
			"[%s][%s] %s %s%s",
			$entry->getTimestamp()->format('Y-m-d H:i:s'),
			$entry->getLevel(),
			$entry->getMessage(),
			json_encode($entry->getContext()),
			PHP_EOL
		);

		$this->expectOutputString($knownOutput);
		$this->driver->write($entry);
	}

	protected function tearDown(): void 
	{
		unset($this->driver);

		parent::tearDown();
	}
}