<?php

namespace Tests\Feature\Authentication;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{

    use RefreshDatabase;

     /**
     * Successful logout attempt
     *
     * @return void
     */
    public function test_user_logout_successful()
    {
       $register_response = $this->post('/api/v1/register',
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

        $token = json_decode($register_response->getContent())->data->token;
        $logout_response = $this->post('/api/v1/logout',
            [],
            [
                "Accept" => "application/json",
                "Authorization" => "Bearer $token"
            ]
        );
        $logout_response->assertStatus(200);
        $logout_response->assertExactJson([
            "status" => 200,
            "data" => [],
            "message" => "Logout Successful."
        ]);
    }


     /**
     * Logout attempt without valid token
     *
     * @return void
     */
    public function test_user_logout_unauthorized()
    {
        $logout_response = $this->post('/api/v1/logout',
            [],
            [
                "Accept" => "application/json",
            ]
        );
        $logout_response->assertStatus(401);
        $logout_response->assertExactJson([
            "status" => 401,
            "error" => "Unauthorized",
            "message" => "Access Denied. You Are Not Presently Authorized To Use This System Function."
        ]);
    }
}
