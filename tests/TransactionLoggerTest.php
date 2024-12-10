<?php

namespace NodePile\PHPTelemetry\Tests;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Exceptions\TransactionEndedException;
use NodePile\PHPTelemetry\Contracts\LoggerInterface;
use NodePile\PHPTelemetry\Contracts\TransactionLoggerInterface;
use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\TransactionLogger;
use NodePile\PHPTelemetry\Models\Transaction;

class TransactionLoggerTest extends TestCase
{
	/**
	 * Test that end transaction prevents further logging to the same transaction.
	 */
	public function testEndTransactionPreventingFurtherLogsToSameTransaction()
	{
		$loggerMock = $this->createMock(LoggerInterface::class);
		$transactionMock = $this->createMock(Transaction::class);

		$transactionLogger = new TransactionLogger($loggerMock, $transactionMock);

		$transactionLogger->endTransaction();

		$this->expectException(TransactionEndedException::class);

		$transactionLogger->log(Level::Debug->value, "I shouldn't be logged because the transaction ended.", []);
	}

	/**
	 * Test that glueContext works as expected and combines transaction info with given subcontext
	 */
	public function testGlueContextCorrectlyCombinesContexts()
	{
		$loggerMock = $this->createMock(LoggerInterface::class);
		$transactionMock = $this->createMock(Transaction::class);

		$transactionMock->method('getId')->willReturn('abc');
		$transactionMock->method('getContext')->willReturn(['user' => 'login']);

		$transactionLogger = new TransactionLogger($loggerMock, $transactionMock);

		$level = Level::Debug->value;
		$message = "Some message to log.";

		$subcontext = [
			'login' => 'success',
		];

		$loggerMock->expects($this->once())
			->method('log')
			->with(
				$level,
				$message,
				[
					'transaction' => 'abc',

					'context' => [
						'user' => 'login',
						'login' => 'success',
					],
				]
			);

		$transactionLogger->log($level, $message, $subcontext);
	}
}
