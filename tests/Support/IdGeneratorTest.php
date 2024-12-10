<?php

namespace NodePile\PHPTelemetry\Tests\Support;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Contracts\IdGeneratorInterface;
use NodePile\PHPTelemetry\Support\IdGenerator;

class IdGeneratorTest extends TestCase 
{
	/**
	 * Test that the id generator implements IdGeneratorInterface
	 */
	public function testImplementsIdGeneratorInterface()
	{
		$idGenerator = new IdGenerator();

		$this->assertInstanceOf(IdGeneratorInterface::class, $idGenerator);
	}

	/**
	 * Test that generate returns a string.
	 */
	public function testGenerateReturnsString()
	{
		$idGenerator = new IdGenerator();

		$this->assertIsString($idGenerator->generate());
	}

	/**
	 * Test that generate returns unique ids.
	 */
	public function testGenerateUniqueIds()
	{
		$idGenerator = new IdGenerator();

		$first = $idGenerator->generate();
		$second = $idGenerator->generate();

		$this->assertNotEquals($first, $second);
	}
}
