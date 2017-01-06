<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiProtectionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAPISecure()
    {
        $this->get('/admin-api/mconfig')->seeStatusCode(403);
    }
}
