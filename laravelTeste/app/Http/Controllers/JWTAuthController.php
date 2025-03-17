<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use function Illuminate\Log\log;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\JWTAuthRequest;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    const INVALID_CREDENTIALS = 'O login ou a senha do usuário são inválidos';
    const NOT_POSSIBLE_CREATE_TOKEN = 'Não foi possível criar o token';
    const USER_NOT_FOUND = 'O usuário não foi encontrado';
    const INVALID_TOKEN = 'O token é inválido';
    const USER_LOGOUT = 'O usuário foi deslogado com sucesso';
    const USER_LOGGIN = 'O usuário foi logado com sucesso';
    const USER_REGISTRED = 'O usuário foi registrado com sucesso';
    const USER_OBTAINED = 'usuário obtido';
    const JWT_TOKEN_REFRESHED = 'O token JWT foi atualizado';

       // User registration
       public function register(JWTAuthRequest $request)
       {
           $validated = $request->validated();
   
           $dataUser = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
            ];
            
           $user = User::create($dataUser);
   
           $token = JWTAuth::fromUser($user);
   
           return $this->sendSweetAlert('success', self::USER_REGISTRED, 201, [$user], $token);
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
               /**
                * @disregard P1013
                */
               $user = auth()->user();
   
               // (optional) Attach the role to the token.
              //  $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

               Log::info("\$e->getMessage(), [\$e]");
               
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
               if (!$user = JWTAuth::parseToken()->authenticate()) return $this->sendSweetalert('error',self::USER_NOT_FOUND, 404);

           } catch (JWTException $e) {
               Log::debug($e->getMessage(), [$e]);
               return $this->sendSweetalert('error', self::INVALID_TOKEN, 400);
           }
   
           return $this->sendSweetalert('success', self::USER_OBTAINED, data:[$user]);
       }
   
       // User logout
       public function logout()
       {
           JWTAuth::invalidate(JWTAuth::getToken());
   
           return $this->sendSweetalert('success', self::USER_LOGOUT);
       }

       // Refresh user JWT TOKEN
       public function refresh() {

        try {
         /**
         * @disregard P1013
         */
            $token = auth()->refresh();

        } catch (JWTException $th) {
            Log::alert($th->getMessage(), ['Exception' => $th]);

            return $this->sendSweetalert('error', self::NOT_POSSIBLE_CREATE_TOKEN, 500);
        }

        return response()->json(['token' => $token]);
       }
}
