<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $authHeader;

    //configura o teste
    public function setUp(): void
    {
        parent::setUp();

        $this->authHeader = ['Content-type' => 'application/json'];
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}
