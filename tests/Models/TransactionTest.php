<?php

namespace NodePile\PHPTelemetry\Tests\Models;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Models\Transaction;

class TransactionTest extends TestCase 
{
	/**
	 * Test that the transaction id is set and returned correctly.
	 */
	public function testGetId()
	{
		$knownId = uniqid();

		$transaction = new Transaction($knownId, []);

		$this->assertIsString($transaction->getId());
		$this->assertSame($knownId, $transaction->getId());
	}

	/**
	 * Test that the transaction context is set and returned correctly.
	 */
	public function testGetContext()
	{
		$knownContext = [
			'user' => 'name',
			'ip' => '127.0.0.1',
		];

		$transaction = new Transaction(uniqid(), $knownContext);

		$this->assertSame($knownContext, $transaction->getContext());
	}
}
