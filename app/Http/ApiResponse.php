<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;
use JsonSerializable;

class ApiResponse
{
    /**
     * Return a new JSON response with error string
     *
     * @param int $status
     * @param string $error
     * @param string|null $message
     * @return Illuminate\Http\JsonResponse
     */
    public static function sendError(
        int $status,
        string $error,
        string $message = null
    ): JsonResponse {
        $response = [
            'status' => $status,
            'error' => $error,
            "message" => ucwords($message)
        ];
        return response()->json($response, $status);
    }

    /**
     * Return a new JSON response with errors array
     *
     * @param int $status
     * @param \JsonSerializable $errors
     * @param string|null $message
     * @return Illuminate\Http\JsonResponse
     */
    public static function sendErrors(
        int $status,
        JsonSerializable $errors,
        string $message = null
    ): JsonResponse {
        $response = [
            'status' => $status,
            "errors" => $errors,
            "message" => ucwords($message)
        ];
        return response()->json($response, $status);
    }


    /**
     * Return a new JSON response with mixed(object|JsonSerializable) data
     *
     * @param int $status
     * @param mixed $data
     * @param string|null $message
     * @return Illuminate\Http\JsonResponse
     */
    public static function send(
        int $status,
        $data = [],
        string $message = null
    ): JsonResponse {
        $response = [
            'status' => $status,
            'data' => $data,
            "message" => ucwords($message)
        ];
        return response()->json($response, $status);
    }
}
