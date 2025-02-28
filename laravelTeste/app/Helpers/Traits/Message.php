<?php

namespace App\Helpers\Traits;

trait Message
{
    public function sendSweetalertMessage(string $icon, string $message, int $statusCode): array
    { 
            return ['data' => ['icon' => $icon, 'message' => $message], 'statusCode' => $statusCode] ;
        
    }
}
