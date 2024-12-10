<?php

namespace NodePile\PHPTelemetry\Support;

use NodePile\PHPTelemetry\Contracts\TimeProviderInterface;

class TimeProvider implements TimeProviderInterface
{
	/**
	 * Returns a new instance of datetime interface.
	 * 
	 * @return \DateTimeInterface
	 */
	public function now(): \DateTimeInterface
	{
		return new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
	}
}
