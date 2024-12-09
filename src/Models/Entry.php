<?php

namespace NodePile\PHPTelemetry\Models;

class Entry
{
	/**
	 * A formattable datetime instance.
	 * 
	 * @var \DateTimeInterface
	 */
	private \DateTimeInterface $timestamp;

	/**
	 * @var string
	 */
	private string $level;

	/**
	 * @var string
	 */
	private string $message;

	/**
	 * @var array
	 */
	private array $context;

	/**
	 * @param \DateTimeInterface $timestamp
	 * @param string $level
	 * @param string $message
	 * @param array $context
	 */
	public function __construct(
		\DateTimeInterface $timestamp,
		string $level,
		string $message,
		array $context = []
	)
	{
		$this->timestamp = $timestamp;
		$this->level = $level;
		$this->message = $message;
		$this->context = $context;
	}

	/**
	 * Get the timestamp of this entry.
	 * 
	 * @return \DateTimeInterface
	 */
	public function getTimestamp(): \DateTimeInterface
	{
		return $this->timestamp;
	}

	/**
	 * Get the log level.
	 * 
	 * @return string
	 */
	public function getLevel(): string 
	{
		return $this->level;
	}

	/**
	 * Get the message that has to be logged.
	 * 
	 * @return string
	 */
	public function getMessage(): string 
	{
		return $this->message;
	}

	/**
	 * Get the context associated with the given log.
	 * 
	 * @return array
	 */
	public function getContext(): array 
	{
		return $this->context;
	}
}
