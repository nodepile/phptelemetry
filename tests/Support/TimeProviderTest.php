<?php

namespace NodePile\PHPTelemetry\Tests\Support;

use PHPUnit\Framework\TestCase;

use NodePile\PHPTelemetry\Contracts\TimeProviderInterface;
use NodePile\PHPTelemetry\Support\TimeProvider;

class TimeProviderTest extends TestCase 
{
	public function testNowReturnsDateTimeInterface()
	{
		$timeProvider = new TimeProvider();

		$this->assertInstanceOf(\DateTimeInterface::class, $timeProvider->now());
	}
}
