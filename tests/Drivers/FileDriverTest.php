<?php

namespace NodePile\PHPTelemetry\Tests\Drivers;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Contracts\DriverInterface;
use NodePile\PHPTelemetry\Exceptions\InvalidConfigException;
use NodePile\PHPTelemetry\Drivers\FileDriver;
use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\Models\Entry;

class FileDriverTest extends TestCase 
{
	/**
	 * Test that the driver throws InvalidConfigException if missing required settings.
	 */
	public function testConstructorThrowsExceptionOnMissingConfig()
	{
		$this->expectException(InvalidConfigException::class);

		$driver = new FileDriver();
	}

	/**
	 * Test test that the driver inits correctly with the right settings.
	 */
	public function testDriverIsDriverInterface()
	{
		$driver = new FileDriver(['file' => 'path']);

		$this->assertInstanceOf(DriverInterface::class, $driver);
	}

	/**
	 * Test that the output has the expected format.
	 */
	public function testWriteOutputFormat()
	{
		$entry = new Entry(new \DateTimeImmutable(), Level::Debug->value, "Something to log.", []);

		$file = tempnam(sys_get_temp_dir(), '');
		$driver = new FileDriver(['file' => $file]);

		$knownOutput = sprintf(
            "[%s][%s] %s %s%s",
            $entry->getTimestamp()->format('Y-m-d H:i:s'),
            $entry->getLevel(),
            $entry->getMessage(),
            json_encode($entry->getContext()),
            PHP_EOL
        );

        $driver->write($entry);

		$this->assertFileExists($file);
		$this->assertStringEqualsFile($file, $knownOutput);

		unlink($file);
	}
}