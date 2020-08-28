<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequiredFieldsForRegistration()
    {
        $this->json(
            'POST',
            '/api/users',
            [],
            ['Accept' => 'application/json']
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."]
                ]
            ]);
    }

    /**
     *Test Email validation
     */
    public function testEmailValidation()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'password' => $this->faker->regexify('[A-Za-z0-9]{20}')
        ];
        $this->json(
            'POST',
            '/api/users',
            $userData,
            ['Accept' => 'application/json']
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email must be a valid email address."],
                ]
            ]);
    }

    public function testUniqueEmail()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->regexify('[A-Za-z0-9]{20}')
        ];

        $this->json(
            'POST',
            '/api/users',
            $userData,
            ['Accept' => 'application/json']
        )->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "message",
                "data" => [
                    "api_token"
                ]
            ]);
        $this->json(
            'POST',
            '/api/users',
            $userData,
            ['Accept' => 'application/json']
        )->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email has already been taken."]
                ]
            ]);
    }
}
