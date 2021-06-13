<?php

namespace App\Http\Controllers;

use App\Http\ApiResponse;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class AuthController extends Controller {


    protected $auth_service;

    /**
     * Create a new controller instance.
     *
     * @param  App\Services\AuthService  $auth_service
     * @return void
     */
    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * Resgister a new user account
     *
     * @param  App\Http\Requests\RegisterUserRequest  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request)
    {
        $new_user = $this->auth_service->createNewUser($request->all());
        return ApiResponse::send(Response::HTTP_CREATED, AuthResource::make($new_user), "Account created successfully.");
    }


    /**
     * Login with user credentials
     *
     * @param  App\Http\Requests\UserLoginRequest  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        $response = $this->auth_service->authenticateUser($request->all());
        if (!$response->user_can_login) {
            return ApiResponse::send(Response::HTTP_UNAUTHORIZED, [], "Invalid credentials. Email or Password Incorrect.");
        }

        return ApiResponse::send(Response::HTTP_OK, AuthResource::make($response->user), "Login successful.");
    }


    /**
     * Logout user by deleting tokens
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponse::send(Response::HTTP_OK, [], "Logout successful.");
    }

}
