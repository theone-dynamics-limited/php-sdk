<?php

use LogdoPhp\Logdo;
use LogdoPhp\Services\Database;
use PHPUnit\Framework\TestCase;

class LogdoTest extends TestCase {
    public function test_instance_returns_logdo_instance()
    {
        $this->assertInstanceOf(
            Logdo::class,
            Logdo::instance()
        );
    }

    public function test_logger_returns_instance_of_database_service()
    {
        $this->assertInstanceOf(
            Database::class,
            Logdo::instance()->logger()
        );
    }
}