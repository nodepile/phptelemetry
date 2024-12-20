<?php

namespace NodePile\PHPTelemetry;

use NodePile\PHPTelemetry\Exceptions\InvalidLevelException;
use NodePile\PHPTelemetry\Contracts\DriverManagerInterface;
use NodePile\PHPTelemetry\Contracts\LoggerInterface;
use NodePile\PHPTelemetry\Contracts\TransactionLoggerInterface;
use NodePile\PHPTelemetry\Contracts\TimeProviderInterface;
use NodePile\PHPTelemetry\Contracts\IdGeneratorInterface;
use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\Models\Entry;
use NodePile\PHPTelemetry\Models\Transaction;

class Logger implements LoggerInterface
{	
	/**
	 * @var DriverManagerInterface
	 */
	private DriverManagerInterface $driverManager;

	/**
	 * @var TimeProviderInterface
	 */
	private TimeProviderInterface $timeProvider;

	/**
	 * @var IdGenerator
	 */
	private IdGeneratorInterface $idGenerator;

	/**
	 * @var array
	 */
	private array $supportedLevels = [];

	public function __construct(
		DriverManagerInterface $driverManager, 
		TimeProviderInterface $timeProvider,
		IdGeneratorInterface $idGenerator
	)
	{
		$this->driverManager = $driverManager;
		$this->timeProvider = $timeProvider;
		$this->idGenerator = $idGenerator;
		
		$this->supportedLevels = $this->loadDefaultLevels();
	}

	/**
	 * Log a runtime error.
	 * 
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function error(string $message, array $context = []): void 
	{
		$this->log(Level::Error->value, $message, $context);
	}

	/**
	 * Log exceptional occurances that are not errors
	 * 
	 * @param string $message 
	 * @param array $context
	 * 
	 * @return void
	 */
	public function warning(string $message, array $context = []): void 
	{
		$this->log(Level::Warning->value, $message, $context);
	}

	/**
	 * Log interesting events.
	 * 
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function info(string $message, array $context = []): void 
	{
		$this->log(Level::Info->value, $message, $context);
	}

	/**
	 * Log detailed debug info.
	 * 
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function debug(string $message, array $context = []): void 
	{
		$this->log(Level::Debug->value, $message, $context);
	}

	public function log(string $level, string $message, array $context = []): void 
	{
		if (!$this->supportsLevel($level)) {
			throw new InvalidLevelException("Level '{$level}' is not supported.");
		}

		$entry = new Entry($this->timeProvider->now(), $level, $message, $context);

		$this->driverManager->getCurrDriver()->write($entry);
	}

	/**
	 * Start a new transaction.
	 * 
	 * @param array $context
	 * 
	 * @return TransactionLoggerInterface
	 */
	public function startTransaction(array $context = []): TransactionLoggerInterface
	{
		$transaction = new Transaction($this->idGenerator->generate(), $context);

		return new TransactionLogger($this, $transaction);
	}

	/**
	 * Add a custom log level.
	 * 
	 * @param string $name
	 * 
	 * @return void
	 * 
	 * @throws InvalidLevelException
	 */
	public function addLevel(string $level): void 
	{
		if ($this->supportsLevel($level)) {
			throw new InvalidLevelException("Level '{$level}' already exists.");
		}

		$this->supportedLevels[] = $level;
	}

	/**
	 * Switch to using another driver.
	 * 
	 * @param string $name
	 * 
	 * @return void
	 */
	public function useDriver(string $name): void 
	{
		$this->driverManager->useDriver($name);
	}

	/**
	 * Get all supported levels.
	 * 
	 * @return array 
	 */
	public function getSupportedLevels(): array
	{
		return $this->supportedLevels;
	}

	/**
	 * Check if the given log level is supported.
	 * 
	 * @param string $name
	 * 
	 * @return bool
	 */
	private function supportsLevel(string $name): bool
	{
		return in_array($name, $this->supportedLevels);
	}

	/**
	 * Load default log levels.
	 * 
	 * @return array
	 */
	private function loadDefaultLevels(): array 
	{
		return array_map(fn(Level $level) => $level->value, Level::cases());
	}
}
