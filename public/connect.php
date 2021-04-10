<?php

require 'vendor/autoload.php';

$api = new Binance\API(__DIR__ . "/connect.json");
//Call this before running any functions
$api->useServerTime();
$api = new Binance\RateLimiter($api);

/** Functions */
require 'functions/calculate.php';
