<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
class AuthController extends Controller
{
    public function postLoginToken(Request $request)
    {
        try{
            $googleUser = Socialite::driver('google')->userFromToken($request->token);
        }catch(Exception $ex){
            log::info("=================================");
            Log::error("Lỗi đăng nhập: " . $ex->getMessage());
            Log::error("Token: " . $request->token);
            log::info("=================================");

            return response()->json([
                'status' => false,
                'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại"
            ]);
        }
        
        $user = User::where('email', $googleUser->email)->first();
        if($user){
            $user->avatar = $googleUser->avatar;
            $user->save();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    "token" => $token,
                    "token_type" => 'Bearer',
                    'user' => $user->toArray()
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại"
        ]);
    }
}
