<?php

namespace Tests\Unit\Controller;

use munkireport\controller\database;
use PHPUnit\Framework\TestCase;

class databaseTest extends TestCase
{

    public function testMigrate()
    {
        $controller = new Database();
        $controller->migrate();
    }
}
