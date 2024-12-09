<?php

namespace NodePile\PHPTelemetry\Tests\Models;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Enums\Level;
use NodePile\PHPTelemetry\Models\Entry;

class EntryTest extends TestCase 
{
	/**
	 * Test that the timestamp is the same as the known one.
	 */
	public function testGetTimestamp()
	{
		$timestamp = new \DateTimeImmutable();

		$entry = new Entry($timestamp, Level::Debug->value, "Something to log.", []);

		$this->assertSame($timestamp, $entry->getTimestamp());
	}

	/**
	 * Test that the level is the same as the known one.
	 */
	public function testGetLevel()
	{
		$level = Level::Debug->value;

		$entry = new Entry(new \DateTimeImmutable(), $level, "Something to log.", []);

		$this->assertSame($level, $entry->getLevel());
	}

	/**
	 * Test that the message is the same as the known one.
	 */
	public function testGetMessage()
	{
		$message = "Something to log.";

		$entry = new Entry(new \DateTimeImmutable(), Level::Debug->value, $message, []);

		$this->assertSame($message, $entry->getMessage());
	}

	/**
	 * Test that the context is the same as the known one.
	 */
	public function testGetContext()
	{
		$context = [
			'user' => 'name',
			'action' => 'login',
		];

		$entry = new Entry(new \DateTimeImmutable(), Level::Debug->value, "Something to log.", $context);

		$this->assertSame($context, $entry->getContext());
	}

	/**
	 * Test that the context is an empty array by default.
	 */
	public function testContextEmptyArrayByDefault()
	{
		$entry = new Entry(new \DateTimeImmutable(), Level::Debug->value, "Something to log.");

		$this->assertSame([], $entry->getContext());
	}
}
