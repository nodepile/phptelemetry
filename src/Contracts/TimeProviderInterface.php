<?php

namespace NodePile\PHPTelemetry\Contracts;

interface TimeProviderInterface
{
	/**
	 * Returns a datetime interface instance making sure there's a formatter.
	 * 
	 * @return \DateTimeInterface
	 */
	public function now(): \DateTimeInterface;
}