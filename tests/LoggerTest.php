<?php

namespace NodePile\PHPTelemetry\Tests;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Exceptions\InvalidLevelException;
use NodePile\PHPTelemetry\Contracts\LoggerInterface;
use NodePile\PHPTelemetry\Contracts\TransactionLoggerInterface;
use NodePile\PHPTelemetry\Contracts\DriverManagerInterface;
use NodePile\PHPTelemetry\Contracts\TimeProviderInterface;
use NodePile\PHPTelemetry\Support\TimeProvider;
use NodePile\PHPTelemetry\Support\IdGenerator;
use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\Logger;

class LoggerTest extends TestCase
{
	private LoggerInterface $logger;

	protected function setUp(): void
	{
		parent::setUp();

		$driverManagerMock = $this->createMock(DriverManagerInterface::class);

		$timeProvider = new TimeProvider();
		$idGenerator = new IdGenerator();

		$this->logger = new Logger($driverManagerMock, $timeProvider, $idGenerator);
	}

	/**
	 * Test that supported levels are loaded correcty.
	 */
	public function testSupportedLevelsLoader()
	{
		$knownLevels = array_map(fn(Level $level) => $level->value, Level::cases());

		$this->assertEqualsCanonicalizing($knownLevels, $this->logger->getSupportedLevels());
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
	 * Test that log with unsupported level throws an InvalidLevelException.
	 */
	public function testLogThrowsExceptionForUnsupportedLevel()
	{
	 	$this->expectException(InvalidLevelException::class);

	 	$this->logger->log("armageddon", "This shouldn't log.", []);
	} 

	/**
	 * Test that startTransaction returns a TransactionLoggerInterface instance.
	 */
	public function testStartTransactionReturnsCorrectInstance()
	{
		$this->assertInstanceOf(TransactionLoggerInterface::class, $this->logger->startTransaction([]));
	}

	public function tearDown(): void 
	{
		unset($this->logger);

		parent::tearDown();
	}
}
