<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($message, $data = [], $token = null, $code = 200)
    {
        $response = [
            "success" => true,
            "message" => $message,
            "data" => $data,
        ];

        if ($token) {
            $response["token"] = $token;
        }

        return response()->json($response, $code);
    }

    protected function errorResponse($message, $code = 400, $data = [])
    {
        $response = [
            "success" => false,
            "message" => $message,
        ];

        if (!empty($data)) {
            $response["data"] = $data;
        }

        return response()->json($response, $code);
    }
    protected function successMessage($message, $code = 200, $newToken = null){
        $response = [
            "success" => true,
            "message" => $message,
        ];
        if(isset($newToken)){
            $response["token"] = $newToken;
        }
        return response()->json($response, $code);
    }
}
