<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;


class OrderTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_order_transaction()
    {
        $faker = Factory::create();
        $password = 'pass1234';
        $quantity = 2;
        $product_id = 4;
        //register user
        $user = [
            'email' => $faker->unique->email,
            'password' => bcrypt($password),
            'auth_key' => Str::random(60),
        ];

        $users = User::create($user);

        $login = [
            'email' => $users->email,
            'password' => $password,
        ];

        $response = $this->json('POST', 'api/login', $login, []);

        $orders = [
            'quantity' => $quantity,
            'product_id' => $product_id,
        ];

        $response = $this->json('POST', 'api/order', $orders, ['Authorization' => 'Bearer '.$response['access_token']]);
        $response->assertStatus(201);
    }

    public function test_fail_order()
    {
        $faker = Factory::create();
        $password = 'pass1234';
        $quantity = 9999;
        $product_id = 4;
        //register user
        $user = [
            'email' => $faker->unique->email,
            'password' => bcrypt($password),
            'auth_key' => Str::random(60),
        ];

        $users = User::create($user);

        $login = [
            'email' => $users->email,
            'password' => $password,
        ];

        $response = $this->json('POST', 'api/login', $login, []);

        $orders = [
            'quantity' => $quantity,
            'product_id' => $product_id,
        ];

        $response = $this->json('POST', 'api/order', $orders, ['Authorization' => 'Bearer '.$response['access_token']]);
        $response->assertStatus(400);
    }
}
