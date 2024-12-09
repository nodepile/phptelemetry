<?php

namespace NodePile\PHPTelemetry\Contracts;

interface LoggerInterface 
{
	/**
	 * Runtime errors.
	 * 
	 * @param string $message
	 * @param array $context
	 * 
	 * @param void
	 */
	public function error(string $message, array $context = []): void;

	/**
	 * Exceptional occurances that are not errors.
	 * 
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function warning(string $message, array $context = []);

	/**
	 * Interesting events.
	 * 
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function info(string $message, array $context = []): void;

	/**
	 * Detailed debug info.
	 * 
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function debug(string $message, array $context = []): void;

	/**
	 * Logs with a custom level
	 * 
	 * @param string $level
	 * @param string $message
	 * @param array $context
	 * 
	 * @return void
	 */
	public function log(string $level, string $message, array $context = []): void; 
}
