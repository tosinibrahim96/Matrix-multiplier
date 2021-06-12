<?php

namespace App\Http\Resources;

use App\Services\AuthService;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $auth_service = new AuthService();
        $token = $auth_service->getNewUserToken($this->resource);

        return [
          "user" => [
            "id" => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            "created_at" => $this->created_at
          ],
          "token" => $token
        ];
    }
}
