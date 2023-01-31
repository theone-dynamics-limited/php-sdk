<?php
require_once __DIR__ . '/../vendor/autoload.php';
use LogdoPhp\Logdo;
$logdo = Logdo::instance()
->logger()
->for("app_id")
->log("hello world")
// ->at("hello world")
->as("local")
// ->with("stack trace")
->level("info")
->go();