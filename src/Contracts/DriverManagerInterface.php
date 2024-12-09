<?php

namespace NodePile\PHPTelemetry\Contracts;

use NodePile\PHPTelemetry\Exceptions\UnknownDriverException;

interface DriverManagerInterface
{
	/**
	 * Register a new driver.
	 * 
	 * @param string $name
	 * @param DriverInterface $driver
	 * 
	 * @return void 
	 * 
	 * @throws UnknownDriverException
	 */
	public function registerDriver(string $name, DriverInterface $driver): void;

	/**
	 * Set the driver that's going to be used.
	 * 
	 * @param string $name
	 * 
	 * @return void 
	 * 
	 * @throws UnknownDriverException
	 */
	public function useDriver(string $name): void;

	/**
	 * Get the driver that's currently in use.
	 * 
	 * @return DriverInterface
	 */
	 public function getCurrDriver(): DriverInterface; 
}