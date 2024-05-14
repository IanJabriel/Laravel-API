<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use Throwable;

class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                return response()->json(['message' => __('passwords.sent')]);
            } else {
                throw new \Exception('passwords.user');
            }
        } catch (\Exception $e) {
            return response()->json(['message' => trans($e->getMessage())], 422);
        }
    }


    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user) use ($request){
                $updatedData = [
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ];
                
                $user->forceFill($updatedData)->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response(['message' => 'Senha redefinida com sucesso']);
        }

        return response(['message' => 'Falha ao redefinir senha']);
    }
}

Class PasswordResetResponse{
    public $message;
    
    public function __construct(array $data)
    {
        $this->message = $data['message'];
    }
}
