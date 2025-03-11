<?php

namespace App\Http\Middleware;

use App\Helpers\Traits\Message;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware 
{
    use Message;
    const INVALID_TOKEN = 'O Token não é válido';
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return $this->sendSweetalert('error', self::INVALID_TOKEN, 401);
        }

        return $next($request);
    }
}
