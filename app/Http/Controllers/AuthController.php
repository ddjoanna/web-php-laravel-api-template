<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * 用戶註冊
     */
    public function register(Request $request)
    {
        // 驗證請求
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        // 創建用戶
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),  // 使用 Hash::make 來加密密碼
        ]);

        // 創建 token
        $token = $user->createToken('apptoken')->plainTextToken;

        // 返回註冊成功的結果與 token
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * 用戶登入
     */
    public function login(Request $request)
    {
        // 驗證請求
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // 找到用戶
        $user = User::where('email', $fields['email'])->first();

        // 檢查密碼
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // 創建 token
        $token = $user->createToken('apptoken')->plainTextToken;

        // 返回登入成功的結果與 token
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * 用戶登出
     */
    public function logout(Request $request)
    {
        // 刪除所有 token，登出
        auth()->user()->tokens()->delete();

        // 返回登出訊息
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * 獲取當前登入用戶的資訊
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
