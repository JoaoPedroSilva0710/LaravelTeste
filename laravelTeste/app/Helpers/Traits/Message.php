<?php

namespace App\Helpers\Traits;

use Illuminate\Http\JsonResponse;

trait Message
{
    public function sendSweetalert(string $icon, string $message, int $statusCode = 200, array $data = [], string $token = ''): JsonResponse
    { 
        return response()->json(['icon' => $icon, 'message' => $message, 'data' => $data, 'token' => $token, 'statusCode' => $statusCode]);
        
    }
}
