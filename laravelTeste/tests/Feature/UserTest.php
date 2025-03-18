<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_route_api_user(): void
    {
        $response = $this->get('/api/user');

        $response->assertStatus(200);
    }


    public function test_route_api_login(): void
    {
        $response = $this->post('/api/login');

        $response->assertStatus(200);
    }

}
