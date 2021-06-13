<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    public function testLoginSuccess()
    {
        $faker = Factory::create();
        $password = 'pass1234';

        $user = User::create([
            'email' => $faker->unique()->email,
            'password' => bcrypt($password),
            'auth_key' => Str::random(60),
        ]);
        $userData = [
            "email" => $user->email,
            "password" => $password,
        ];
        $response = $this->json('POST', 'api/login', $userData, []);
        $response->assertStatus(201);
    }

    public function testLoginMismatchCredentials()
    {
        $userData = [
            "email" => 'blackmail@gmail.com',
            "password" => 'pass1234',
        ];
        $response = $this->json('POST', 'api/login', $userData, []);
        $response->assertStatus(401);
    }
}
