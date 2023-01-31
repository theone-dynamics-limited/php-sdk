<?php
require_once __DIR__ . '/../vendor/autoload.php';
use LogdoPhp\Logdo;
$logdo = Logdo::instance()
    ->logger()
    ->for(app_id: "app_id")
    ->log(log: "hello world")
    ->at(incident_datetime: "2023-01-31 12:07:56")
    ->as(environment: "local")
    ->with(stack_trace: "stack trace")
    ->level(log_level: "info")
    ->go();