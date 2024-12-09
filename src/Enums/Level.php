<?php

namespace NodePile\PHPTelemetry\Enums;

enum Level: string
{
	case Error   = 'error';
	case Warning = 'warning';
	case Info    = 'info';
	case Debug   = 'debug';
}
