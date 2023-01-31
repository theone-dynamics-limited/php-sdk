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

    public function test_the_logdo_class_has_required_api_methods()
    {
        $this->assertTrue(method_exists(Logdo::class, "instance"));
        $this->assertTrue(method_exists(Logdo::class, "logger"));
        $this->assertTrue(method_exists(Logdo::class, "go"));
    }
}