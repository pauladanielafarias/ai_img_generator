<?php

// Usar el sistema de autoload de composer
require '../vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;


// Create some handlers
$stream = new StreamHandler('../logs.log', Level::Debug);
$firephp = new FirePHPHandler();

// the default date format is "Y-m-d\TH:i:sP"
$dateFormat = "Y-m-d H:i:s";
// the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
// we now change the default output format according to our needs.
$output = "[%datetime%] %channel%.%level_name%: %message% %context%\n";

$formatter = new LineFormatter($output, $dateFormat);
$stream->setFormatter($formatter);

// Create the main logger of the app
$logger = new Logger('logger');
$logger->pushHandler($stream);
$logger->pushHandler($firephp);

// You can now use your logger
$logger->info('Logger is now ready');

?>