<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Store a new user in the database
     *
     * @param array  $newuser_data
     * @return App\Models\User $user
     */
    public function createNewUser(array $newuser_data): User {
      $user = User::create([
        'name' => $newuser_data['name'],
        'email' => $newuser_data['email'],
        'password' => bcrypt($newuser_data['password'])
      ]);

      return $user;
    }

     /**
     * Get authentication token for the newly created user
     *
     * @param App\Models\User $user
     * @return string
     */
    public function getNewUserToken(User $user) {
      return $user->createToken('user_created')->plainTextToken;
    }


    /**
     * Check if user login credentials are correct
     *
     * @param array $login_credentials
     * @return object
     */
    public function authenticateUser(array $login_credentials) {

      $response = (object)[];
      $user = User::where('email', $login_credentials['email'])->first();

      if (!$user) {
        $response->user_can_login = false;
        return $response;
      }

      $db_password = $user->password;
      $request_password = $login_credentials['password'];
      $response->user_can_login = Hash::check($request_password,$db_password);
      $response->user = $user;

      return $response;
    }
}
