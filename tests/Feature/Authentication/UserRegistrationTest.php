<?php

namespace Tests\Feature\Authentication;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{

    use RefreshDatabase;

     /**
     * Successful account creation attempt
     *
     * @return void
     */
    public function test_create_new_useraccount_successful()
    {
        $response = $this->post('/api/v1/register',
            [
                "name" => "Test name",
                "email" => "testemail@mail.com",
                "password" => "password",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(201);
        $response->assertJsonStructure([
            "data" =>
                [
                    "user" => [
                    "name",
                    "email",
                    "created_at"
                ],
                "token"
            ]
        ]);
    }

    /**
     * Name must be part of the request
     *
     * @return void
     */
    public function test_create_new_useraccount_name_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "email" => "testemail@mail.com",
                "password" => "password",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                     'name' => [
                          'The name field is required.'
                     ]
                 ]
            ]
        );
    }


    /**
     * Name must be a string value
     *
     * @return void
     */
    public function test_create_new_useraccount_name_mustbe_string()
    {
        $response = $this->post('/api/v1/register',
            [
                "name" => 12345,
                "email" => "testemail@mail.com",
                "password" => "password",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                     'name' => [
                          'The name must be a string.'
                     ]
                 ]
            ]
        );
    }


     /**
     * Email is must be part of the request
     *
     * @return void
     */
    public function test_create_new_useraccount_email_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "name" => "Random name",
                "password" => "password",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                     'email' => [
                          'The email field is required.'
                     ]
                 ]
            ]
        );
    }


     /**
     * Email must be a string value and valid email
     *
     * @return void
     */
    public function test_create_new_useraccount_email_mustbe_string_and_valid()
    {
        $response = $this->post('/api/v1/register',
            [
                "name" => "Random name",
                "email" => 12345,
                "password" => "password",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                     'email' => [
                         'The email must be a string.',
                         'The email must be a valid email address.'
                     ]
                 ]
            ]
        );
    }


     /**
     * Email must be unique for each account
     *
     * @return void
     */
    public function test_create_new_useraccount_email_mustbe_unique()
    {
        $this->post('/api/v1/register',
            [
                "name" => "Random name",
                "email" => "duplicate@gmail.com",
                "password" => "password",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );
        $response = $this->post('/api/v1/register',
            [
                "name" => "Random name",
                "email" => "duplicate@gmail.com",
                "password" => "password",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                     'email' => [
                         'The email has already been taken.'
                     ]
                 ]
            ]
        );
    }


    /**
     * Password must be part of the request
     *
     * @return void
     */
    public function test_create_new_useraccount_password_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "name" => "Random name",
                "email" => "testemail@mail.com",
                "password_confirmation" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                     'password' => [
                          'The password field is required.'
                     ]
                 ]
            ]
        );
    }

    /**
     * Password must be part of the request
     *
     * @return void
     */
    public function test_create_new_useraccount_password_confirmation_missing()
    {
        $response = $this->post('/api/v1/register',
            [
                "name" => "Random name",
                "email" => "testemail@mail.com",
                "password" => "password"
            ],
            [
                "Accept" => "application/json"
            ]
        );

        $response->assertStatus(422);
        $response->assertJson(
            [
                'errors' => [
                     'password' => [
                          'The password confirmation does not match.'
                     ]
                 ]
            ]
        );
    }

}
