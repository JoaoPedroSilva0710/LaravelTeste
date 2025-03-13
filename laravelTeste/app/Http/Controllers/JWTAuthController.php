<?php

namespace App\Http\Controllers;

use App\Http\Requests\JWTAuthRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use function Illuminate\Log\log;
use function Laravel\Prompts\error;

class JWTAuthController extends Controller
{
    const INVALID_CREDENTIALS = 'O login ou a senha do usuário são inválidos';
    const NOT_POSSIBLE_CREATE_TOKEN = 'Não foi possível criar o token';
    const USER_NOT_FOUND = 'O usuário não foi encontrado';
    const INVALID_TOKEN = 'O token é inválido';
    const USER_LOGOUT = 'O usuário foi deslogado com sucesso';
    const USER_LOGGIN = 'O usuário foi logado com sucesso';
    const USER_REGISTRED = 'O usuário foi registrado com sucesso';
       // User registration
       public function register(JWTAuthRequest $request)
       {
           $validated = $request->validated();
   
           $dataUser = ['name' => $validated['name'],
           'email' => $validated['email'],
           'password' => Hash::make($validated['password'])];

           $user = User::create($dataUser);
   
           $token = JWTAuth::fromUser($user);
   
           return $this->sendSweetAlert('error', self::USER_REGISTRED, 201, [$user], $token);
       }
   
       // User login
       public function login(Request $request)
       {
           $credentials = $request->only('email', 'password');
   
           try {
               if (! $token = JWTAuth::attempt($credentials)) {
                return $this->sendSweetAlert('error', self::INVALID_CREDENTIALS, 401);
               }
   
               // Get the authenticated user.
               $user = auth()->user();
   
               // (optional) Attach the role to the token.
               $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

               Log::emergency("\$e->getMessage(), [\$e]");

               return $this->sendSweetalert('success', self::USER_LOGGIN, token:$token);

           } catch (JWTException $e) {
                Log::emergency($e->getMessage(), [$e]);
               return $this->sendSweetalert('error', self::NOT_POSSIBLE_CREATE_TOKEN, 500);
           }
       }
   
       // Get authenticated user
       public function getUser()
       {
           try {
               if (! $user = JWTAuth::parseToken()->authenticate()) return $this->sendSweetalert('error',self::USER_NOT_FOUND, 404);

           } catch (JWTException $e) {
               Log::debug($e->getMessage(), [$e]);
               return $this->sendSweetalert('error', self::INVALID_TOKEN, 400);
           }
   
           return $this->sendSweetalert('success', 'usuário obtido', data:[$user]);
       }
   
       // User logout
       public function logout()
       {
           JWTAuth::invalidate(JWTAuth::getToken());
   
           return $this->sendSweetalert('success', self::USER_LOGOUT);
       }
}
