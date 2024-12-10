<?php

namespace NodePile\PHPTelemetry\Drivers;

use NodePile\PHPTelemetry\Exceptions\InvalidConfigException;
use NodePile\PHPTelemetry\Contracts\DriverInterface;
use NodePile\PHPTelemetry\Models\Entry;

class FileDriver implements DriverInterface
{
	/**
	 * The path to the file in which the log will be written.
	 * 
	 * @var string
	 */
	protected string $file;

	/**
	 * @param array $settings
	 * 
	 * @throws InvalidConfigException
	 */
	public function __construct(array $settings = [])
	{
		if (!array_key_exists('file', $settings)) {
			throw new InvalidConfigException("Missing 'file' path.");
		}

		$this->file = $settings['file'];
	}

	/**
	 * Writes the given message & context in a given file.
	 * 
	 * @param Entry $entry
	 * 
	 * @return void
	 */
	public function write(Entry $entry): void 
	{
		$log = sprintf(
            "[%s][%s] %s %s%s",
            $entry->getTimestamp()->format('Y-m-d H:i:s'),
            $entry->getLevel(),
            $entry->getMessage(),
            json_encode($entry->getContext()),
            PHP_EOL
        );

        file_put_contents($this->file, $log, FILE_APPEND | LOCK_EX);
	}

}
