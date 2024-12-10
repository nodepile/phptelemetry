<?php

namespace NodePile\PHPTelemetry\Contracts;

interface TransactionLoggerInterface extends LoggerInterface
{
	public function endTransaction(): void;
}
