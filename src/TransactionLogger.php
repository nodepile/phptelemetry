<?php

namespace NodePile\PHPTelemetry;

use NodePile\PHPTelemetry\Exceptions\TransactionEndedException;
use NodePile\PHPTelemetry\Contracts\LoggerInterface;
use NodePile\PHPTelemetry\Contracts\TransactionLoggerInterface;
use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\Models\Transaction;

class TransactionLogger implements TransactionLoggerInterface
{
	/**
	 * @var LoggerInterface
	 */
	private LoggerInterface $logger;	

	/**
	 * @var Transaction
	 */
	private Transaction $transaction;

	/**
	 * Wether the current transaction ended or not.
	 * 
	 * @var bool
	 */
	private bool $ended = false;

	/**
	 * @param LoggerInterface $logger
	 * @param Transaction $transaction
	 */
	public function __construct(LoggerInterface $logger, Transaction $transaction)
	{
		$this->logger = $logger;
		$this->transaction = $transaction;
	}

	/**
	 * Log a runtime error during transaction.
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
	 * Log exceptional occurances that are not errors during a transaction.
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
	 * Log interesting events during a transaction.
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
	 * Log detailed debug info during a transaction.
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

	/**
	 * Log the given message & context during a transaction
	 * 
	 * @param string $level
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function log(string $level, string $message, $context = []): void 
	{
		$this->notEnded();

		$this->logger->log($level, $message, $this->glueContext($context));
	}

	/**
	 * End the current transaction.
	 * 
	 * @return void
	 */
	public function endTransaction(): void 
	{
		$this->ended = true;
	}

	/**
	 * Checks if current transaction can still be used to log stuff.
	 * 
	 * @return void
	 * 
	 * @throws TransactionEndedException
	 */
	private function notEnded(): void 
	{
		if ($this->ended) {
			throw new TransactionEndedException("Can't log in this transaction.");
		}
	}

	/**
	 * Put all the transaction & subcontext pieces together.
	 * 
	 * @param array $subcontext
	 * 
	 * @return array
	 */
	private function glueContext(array $subcontext = [])
	{
		return [ 
			'transaction' => $this->transaction->getId(),
			
			'context'     => array_merge(
				$this->transaction->getContext(),
				$subcontext,
			),
		];
	}
}
