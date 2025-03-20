<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void {
        parent::setUp();

        User::factory(10)->create();
    }

    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        
        $this->assertTrue(true);
    }


    public function test_check_if_users_getting_fetched_with_id(): void
    {
        User::factory(1)->create(['id' => 100]);

        $response = User::where('id', 100)->get();

        $this->assertCount(1, $response);
        $this->assertEquals(100 ,$response[0]->id);

    }

    public function test_check_if_all_users_have_a_password_not_null(): void
    {
        $response = User::all();

        $this->assertFalse($response->contains(function($item, $key){
            return null  === $item['password'];
        }));
    }

}
