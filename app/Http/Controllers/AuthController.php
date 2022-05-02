<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function adminLogin()
    {
        return view('auth.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function adminGoogleCallback()
    {
        $ggUser = Socialite::driver('google')->user();
        $user = User::where('email', $ggUser->email)->first();
        if ($user && $user->hasRole([config('util.SUPER_ADMIN_ROLE'), config('util.ADMIN_ROLE'), config('util.JUDGE_ROLE')])) {
            Auth::login($user);
            return redirect(route('dashboard'));
        }
        return redirect(route('login'))->with('msg', "Tài khoản của bạn không có quyền truy cập!");
    }
    public function postLoginToken(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->userFromToken($request->token);
        } catch (Exception $ex) {
            Log::info("=================================");
            Log::error("Lỗi đăng nhập: " . $ex->getMessage());
            Log::error("Token: " . $request->token);
            log::info("=================================");

            return response()->json([
                'status' => false,
                'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại"
            ]);
        }

        $user = User::with('roles')->where('email', $googleUser->email)->first();
        if ($user) {
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

    public function fake_login(Request $request)
    {
        $user = User::with('roles')->where('email', $request->email)->first();
        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    'token' => $token,
                    'user' => $user->toArray()
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'payload' => "email không tồn tại"
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}