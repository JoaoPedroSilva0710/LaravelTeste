<?php

namespace App\Helpers\Traits;

use Illuminate\Http\JsonResponse;

trait Message
{
    public function sendSweetalert(string $icon, string $message, int $statusCode = 200, array $data = [], string $token = ''): JsonResponse
    { 
        $arrayResponse = ['icon' => $icon, 'message' => $message, 'statusCode' => $statusCode];
        
        if(!empty($data)) $arrayResponse['data'] = $data;
        if(!empty($token)) $arrayResponse['token'] = $token;
    
        return response()->json($arrayResponse);
    }
}
