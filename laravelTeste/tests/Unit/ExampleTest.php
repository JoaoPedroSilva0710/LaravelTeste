<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        
        $this->assertTrue(true);
    }


    public function test_check_if_users_getting_fetched_with_id(): void
    {
        User::factory(10)->create();

        $response = DB::table('users')->first();

        dd($response);

    }
}
