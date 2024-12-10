<?php

namespace NodePile\PHPTelemetry\Models;

class Transaction
{
	/**
	 * @var string
	 */
	private string $id;

	/**
	 * @var array
	 */
	private array $context;

	/**
	 * @param string $id
	 * @param array $context
	 */
	public function __construct(string $id, array $context = [])
	{
		$this->id = $id;
		$this->context = $context;
	}

	/**
	 * Get the transaction id.
	 * 
	 * @return string
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * Get the transaction context.
	 * 
	 * @return array
	 */
	public function getContext(): array 
	{
		return $this->context;
	}
}