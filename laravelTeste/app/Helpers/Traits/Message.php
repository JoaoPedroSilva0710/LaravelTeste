<?php

namespace App\Helpers\Traits;

use Illuminate\Http\JsonResponse;

trait Message
{
    public function sendSweetalert(string $icon, string $message, int $statusCode = 200): JsonResponse
    { 
            return response()->json(['data' => ['icon' => $icon, 'message' => $message], 'statusCode' => $statusCode]) ;
        
    }
}
