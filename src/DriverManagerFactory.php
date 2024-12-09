<?php

namespace NodePile\PHPTelemetry;

use NodePile\PHPTelemetry\Exceptions\InvalidConfigException;
use NodePile\PHPTelemetry\Exceptions\UnknownDriverException;
use NodePile\PHPTelemetry\Contracts\DriverManagerInterface;
use NodePile\PHPTelemetry\Support\DriverManager;

class DriverManagerFactory
{
	/**
	 * Create a new driver manager instance.
	 * 
	 * @param array $config
	 * 
	 * @return DriverManagerInterface
	 */
	public function create(array $config = []): DriverManagerInterface
	{
		if (!array_key_exists('default', $config)) {
			throw new InvalidConfigException("Missing 'default' driver.");
		}

		if (!array_key_exists('drivers', $config)) {
			throw new InvalidConfigException("Missing 'drivers' config.");
		}
		
		$manager = new DriverManager();

		foreach($config['drivers'] as $name => $cfg) {
			$class = $cfg['driver'] ?? null;
			$settings = $cfg['settings'] ?? [];

			if (!class_exists($class)) {
				throw new UnknownDriverException("Driver '{$name}' was not found.");
			}

			$driver = new $class($settings);

			$manager->registerDriver($name, $driver);
		}

		$manager->useDriver($config['default']);

		return $manager;
	}
}