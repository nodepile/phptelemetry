<?php

namespace NodePile\PHPTelemetry\Support;

use NodePile\PHPTelemetry\Exceptions\UnknownDriverException;
use NodePile\PHPTelemetry\Contracts\DriverManagerInterface;
use NodePile\PHPTelemetry\Contracts\DriverInterface;

class DriverManager implements DriverManagerInterface
{
	/**
	 * All registered drivers.
	 * 
	 * @var array
	 */
	private array $drivers = [];

	/**
	 * The name of the driver that's currently in use.
	 * 
	 * @var string
	 */
	private string $currDriver;

	/**
	 * Register a new driver (overwrites if same name already exists).
	 * 
	 * @param string $name
	 * @param DriverInterface $driver
	 * 
	 * @return void
	 * 
	 * @throws UnknownDriverException
	 */
	public function registerDriver(string $name, DriverInterface $driver): void 
	{
		$this->drivers[$name] = $driver;
	}

	/**
	 * Set the driver that's going to be used from now on.
	 * 
	 * @param string $name
	 * 
	 * @return void
	 * 
	 * @throws UnknownDriverException
	 */
	public function useDriver(string $name): void
	{
		if (!array_key_exists($name, $this->drivers)) {
			throw new UnknownDriverException("Driver '{$name}' was not found.");
		}

		$this->currDriver = $name;
	}

	/**
	 * Get the driver that's currently in use.
	 * 
	 * @return DriverInterface
	 */
	public function getCurrDriver(): DriverInterface
	{
		return $this->drivers[$this->currDriver];
	}
}