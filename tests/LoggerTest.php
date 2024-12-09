<?php

namespace NodePile\PHPTelemetry\Tests;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Exceptions\InvalidLevelException;
use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\Logger;

class LoggerTest extends TestCase
{
	private Logger $logger;

	protected function setUp(): void
	{
		parent::setUp();

		$this->logger = new Logger();
	}

	/**
	 * Test that supported levels are loaded correcty.
	 */
	public function testSupportedLevelsLoader()
	{
		$knownLevels = array_map(fn(Level $level) => $level->value, Level::cases());
		$loadedLevels = $this->logger->getSupportedLevels();

		$this->assertEqualsCanonicalizing($knownLevels, $loadedLevels);
	}

	/**
	 * Test that new levels are added correctly.
	 */
	public function testAddLevelAddsNewLevel()
	{
		$level = "armageddon";

		$this->logger->addLevel($level);

		$this->assertContains($level, $this->logger->getSupportedLevels());
	}

	/**
	 * Test that adding a level that already exists throws an InvalidLevelException.
	 */
	public function testAddLevelThrowsExceptionForExistingLevel()
	{
		$this->expectException(InvalidLevelException::class);

		$this->logger->addLevel(Level::Debug->value);
	}

	/**
	 * Test log with supported level.
	 */
	public function testLogWithSupportedLevel()
	{
		$this->expectNotToPerformAssertions();

		$this->logger->log(Level::Debug->value, "Log this!", []);
	}

	/**
	 * Test that log with unsupported level thros an InvalidLevelException
	 */
	public function testLogThrowsExceptionForUnsupportedLevel()
	{
	 	$this->expectException(InvalidLevelException::class);

	 	$this->logger->log("armageddon", "This shouldn't log.", []);
	} 

	public function tearDown(): void 
	{
		unset($this->logger);

		parent::tearDown();
	}
}
