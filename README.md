![Scr](https://i.imgur.com/9lDfVPR.png)

## Installation

Install the latest version using

```bash
composer require nodepile/phptelemetry
```

## Example usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use NodePile\PHPTelemetry\Drivers\CliDriver;
use NodePile\PHPTelemetry\Drivers\FileDriver;
use NodePile\PHPTelemetry\Support\TimeProvider;
use NodePile\PHPTelemetry\Support\IdGenerator;
use NodePile\PHPTelemetry\DriverManagerFactory;
use NodePile\PHPTelemetry\Logger;

// For now i created just a simple cli and a file driver but you can expand this by creating however many driver you need.
$config = [
	'default' => 'cli',

	'drivers' => [
		'cli' => [
			'driver' => CliDriver::class,
		],

		'file' => [
			'driver' => FileDriver::class,
			'settings' => [
				'file' => __DIR__ . '/my.log',
			],
		],
	],
];

$driverManagerFactory = new DriverManagerFactory();
$driverManager = $driverManagerFactory->create($config);

// You can pass your own time provider or the built in one.
$timeProvider = new TimeProvider();

// You can pass your own id generator (useful if you already have a standardized transaction id - trace - format).
$idGenerator = new IdGenerator();

$logger = new Logger($driverManager, $timeProvider, $idGenerator);

// Simple logging with existing levels.
$logger->info("User logged in successfully.", ['id' => 50]);
$logger->warning("SSL handshake failed.", ['ip' => '123.4.5.6']);
$logger->error("DB conn failed. The server went away.", ['code' => 2006]);

// Log using custom levels.
// Logging with a level that was not previously added using ->addLevel(...) will throw an InvalidLevelException 
$logger->addLevel("custom");
$logger->log("custom", "Log some custom message.", ['with' => 'or without context']);

// Log during a transaction.
$transaction = $logger->startTransaction(['user' => 'login']);

$transaction->info("Received auth request.", ['ip' => '127.0.0.1']);
$transaction->info("Credentials validated successfully.");
$transaction->error("Failed to log the user in.", ['reasons' => 'can be logged']);

$transaction->endTransaction();

// Trying to use the same transaction after it ended will result in a TransactionEndedException
// $transaction->info("I should result in a runtime exception because the transaction ended.");

// Switch driver
$logger->useDriver('cli');
$logger->info("I am logged to CLI.", ['with' => 'some context']);

$logger->useDriver('file');
$logger->info("I am logged to a file.", ['with' => 'a different context']);
```

## Add a custom driver

By default this package comes with just ```cli``` and ```file``` drivers. If you want to build your own driver for, let's say, Redis simply implement ```NodePile\PHPTelemetry\Contracts\DriverInterface``` and then pass it to the driver manager through the 'drivers' key in your config.
