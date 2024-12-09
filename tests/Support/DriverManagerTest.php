<?php

namespace NodePile\PHPTelemetry\Tests\Support;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Exceptions\UnknownDriverException;
use NodePile\PHPTelemetry\Contracts\DriverInterface;
use NodePile\PHPTelemetry\Support\DriverManager;

class DriverManagerTest extends TestCase 
{
	private DriverManager $driverManager;

	private DriverInterface $driverMock;

	protected function setUp(): void
	{
		parent::setUp();

		$this->driverManager = new DriverManager();
		$this->driverMock = $this->createMock(DriverInterface::class);
	}

	/**
	 * Test that drivers are registered properly when the params are right.
	 */
	public function testRegisterDriverSuccess()
	{
		$this->driverManager->registerDriver('cli', $this->driverMock);
		$this->driverManager->useDriver('cli');

		$this->assertSame($this->driverMock, $this->driverManager->getCurrDriver());
	}

	/**
	 * Test that registering a driver that doesn't implement DriverInterface throws UnknownDriverException.
	 */
	public function testRegisterDriverThrowsTypeError()
	{
		$this->expectException(\TypeError::class);

		$notDriver = new \stdClass();

		$this->driverManager->registerDriver('blockchain', $notDriver);
	}

	/**
	 * Test that curr driver returns a DriverInterface.
	 */
	public function testGetCurrDriverReturnsDriverInterface()
	{
		$this->driverManager->registerDriver('cli', $this->driverMock);
		$this->driverManager->useDriver('cli');

		$currDriver = $this->driverManager->getCurrDriver();

		$this->assertInstanceOf(DriverInterface::class, $currDriver);
		$this->assertSame($this->driverMock, $currDriver);
	}

	/**
	 * Test that using a driver that exists works.
	 */
	public function testUseDriverSuccess()
	{
		$this->driverManager->registerDriver('cli', $this->driverMock);
		$this->driverManager->useDriver('cli');

		$this->assertSame($this->driverMock, $this->driverManager->getCurrDriver());
	}

	/**
	 * Test that using a driver that was not registered fails and throws UnknownDriverException
	 */
	public function testUseDriverThrowsUnknownDriverException()
	{
		$this->expectException(UnknownDriverException::class);

		$this->driverManager->useDriver('blockchain');
	}

	protected function tearDown(): void 
	{
		unset($this->driverManager);

		parent::tearDown();
	}
}
