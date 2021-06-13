<?php

namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    public function testregisterSuccess()
    {
        $faker = Factory::create();
        $userData = [
            "email" => $faker->unique()->email,
            "password" => bcrypt($faker->unique()->password),
        ];
        $response = $this->json('POST', 'api/register', $userData, []);
        $response->assertStatus(201);
    }

    public function testCheckIfEmailAlreadyTaken()
    {
        $userData = [
            "email" => 'test@email.com',
            "password" => bcrypt('test1234'),
        ];
        $this->json('POST', 'api/register', $userData, []);

        $userData = [
            "email" => 'test@email.com',
            "password" => bcrypt('test1234'),
        ];
        $response = $this->json('POST', 'api/register', $userData, []);
        $response->assertStatus(401);
    }
}
