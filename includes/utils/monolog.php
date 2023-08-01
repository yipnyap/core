<?php
use Monolog\Logger;
use Logtail\Monolog\LogtailHandler;

$LogtailServiceLogger = new Logger("logtail-source");
$LogtailServiceLogger->pushHandler(new LogtailHandler(getenv('YIPNYAP_LOGTAIL_SOURCE_ID')));
