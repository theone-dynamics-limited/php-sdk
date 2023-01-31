<?php

use LogdoPhp\Services\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
    public function test_the_database_class_has_required_api_methods()
    {
        $this->assertTrue(method_exists(Database::class, "log"));
        $this->assertTrue(method_exists(Database::class, "as"));
        $this->assertTrue(method_exists(Database::class, "level"));
        $this->assertTrue(method_exists(Database::class, "for"));
        $this->assertTrue(method_exists(Database::class, "at"));
        $this->assertTrue(method_exists(Database::class, "go"));
    }
}