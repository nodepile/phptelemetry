<?php

namespace NodePile\PHPTelemetry\Tests;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Exceptions\InvalidConfigException;
use NodePile\PHPTelemetry\Exceptions\UnknownDriverException;
use NodePile\PHPTelemetry\Contracts\DriverManagerInterface;
use NodePile\PHPTelemetry\Contracts\DriverInterface;
use NodePile\PHPTelemetry\DriverManagerFactory;

class DriverManagerFactoryTest extends TestCase 
{
	private DriverManagerFactory $driverManagerFactory;

	protected function setUp(): void 
	{
		parent::setUp();

		$this->driverManagerFactory = new DriverManagerFactory();
	}

	/**
	 * Test that the factory returns a DriverManagerInterface
	 */
	public function testCreateReturnsDriverManagerInterface()
	{
		$driverMock = $this->createMock(DriverInterface::class);
		$class = get_class($driverMock);

		$config = [
			'default' => 'mock',

			'drivers' => [
				'mock' => [
					'driver' => $class,
				],
			],
		];

		$manager = $this->driverManagerFactory->create($config);

		$this->assertInstanceOf(DriverManagerInterface::class, $manager);
		$this->assertSame($class, get_class($manager->getCurrDriver()));
	}

	/**
	 * Test that the factory throws InvalidConfigException when missing 'default' driver.
	 */
	public function testCreateThrowsInvalidConfigExceptionWhenMissingDefaultDriver()
	{
		$driverMock = $this->createMock(DriverInterface::class);

		$config = [
			'drivers' => [],
		];

		$this->expectException(InvalidConfigException::class);

		$this->driverManagerFactory->create($config);
	}

	/**
	 * Test that the factory throws InvalidConfigException when missing 'drivers' param.
	 */
	public function testCreateThrowsInvalidConfigExceptionWhenMissingDriversParam()
	{
		$config = [
			'default' => 'mock',
		];

		$this->expectException(InvalidConfigException::class);

		$this->driverManagerFactory->create($config);
	}

	/**
	 * Test that the factory throws UnknownDriverException when the driver class is not found.
	 */
	public function testCreateThrowsUnknownDriverExceptionWhenDriverNotFound()
	{
		$config = [
			'default' => 'mock',

			'drivers' => [
				'mock' => [
					'driver' => 'NotDriverInterface',
				],
			],
		];

		$this->expectException(UnknownDriverException::class);
		
		$this->driverManagerFactory->create($config);
	}

	/**
	 * Test that the factory works with multiple drivers.
	 */
	public function testCreateWorksWithMultipleDrivers()
	{
		$firstMock = $this->createMock(DriverInterface::class);
		$secondMock = $this->createMock(DriverInterface::class);

		$firstClass = get_class($firstMock);
		$secondClass = get_class($secondMock);

		$config = [
			'default' => 'first',

			'drivers' => [
				'first' => [
					'driver' => $firstClass,
				],

				'second' => [
					'driver' => $secondClass,
				],
			],
		];

		$manager = $this->driverManagerFactory->create($config);

		$this->assertInstanceOf(DriverManagerInterface::class, $manager);

		$manager->useDriver('first');
		$this->assertSame($firstClass, get_class($manager->getCurrDriver()));
	
		$manager->useDriver('second');
		$this->assertSame($secondClass, get_class($manager->getCurrDriver()));
	}

	protected function tearDown(): void 
	{
		unset($this->driverManagerFactory);
		
		parent::tearDown();
	}
}
