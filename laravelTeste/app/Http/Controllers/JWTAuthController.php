<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
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
       // User registration
       public function register(Request $request)
       {
           $validator = Validator::make($request->all(), [
               'name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'password' => 'required|string|min:6|confirmed',
           ]);
   
           if($validator->fails()){
               return $this->sendSweetalert('error', $validator->errors()->toJson(), 400);
           }
   
           $user = User::create([
               'name' => $request->get('name'),
               'email' => $request->get('email'),
               'password' => Hash::make($request->get('password')),
           ]);
   
           $token = JWTAuth::fromUser($user);
   
           return $this->sendSweetAlert('error', self::USER_REGISTRED, 201, nameAdicionalData:'user_data', adicionalData:['user' => $user, 'token' => $token]);
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
   

               return $this->sendSweetalert('success', self::USER_LOGGIN, data:[$user], token:$token);

               return $this->sendSweetalert('success', self::USER_LOGGIN, token:'token');

           } catch (JWTException $e) {
               return $this->sendSweetalert('error', self::NOT_POSSIBLE_CREATE_TOKEN, 500);
           }
       }
   
       // Get authenticated user
       public function getUser()
       {
           try {
               if (! $user = JWTAuth::parseToken()->authenticate()) {
                   return $this->sendSweetalert('error',self::USER_NOT_FOUND, 404);
               }
           } catch (JWTException $e) {
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
