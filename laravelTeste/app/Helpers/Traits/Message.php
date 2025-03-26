<?php

namespace App\Helpers\Traits;

use Illuminate\Http\JsonResponse;
/**
 * This Trait is responsible to send standards messages as response.
 */
trait Message
{
    /**
     * Responsible to send a Json from front-end, whit the necessary things to up a sweet alert in the screen.
     * @param string $icon Is the icon from switchAlert
     * @param string $message Is the message up that will be displayed on the screen
     * @param int $statusCode Is the Status code of the response
     * @param array $data Is an optional argument and may contain some data that should be sent as a response
     * @param string $token Is an optional argument and may contain a JWT Token that should be sent as a response
     */
    public function sendSweetalert(string $icon, string $message, int $statusCode = 200, array $data = [], string $token = ''): JsonResponse
    { 
        $arrayResponse = ['icon' => $icon, 'message' => $message, 'statusCode' => $statusCode];
        
        if(!empty($data)) $arrayResponse['data'] = $data;
        if(!empty($token)) $arrayResponse['token'] = $token;
    
        return response()->json($arrayResponse);
    }
}
