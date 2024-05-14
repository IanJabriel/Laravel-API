<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request){
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            return $this->success('Authorized',200, [
                'token' => $request->user()->createToken('token_usuario')->plainTextToken
            ]);
        }
        return $this->error('Unauthorized',401);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return $this->success('Token Rovoked',200);
    }
}