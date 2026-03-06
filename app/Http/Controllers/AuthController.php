<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'login_field' => 'required',
            'password' => 'required',
        ]);

        $loginField = $request->login_field;

        // Cho phép login bằng email hoặc phone
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';

        if (!Auth::attempt([
            $fieldType => $loginField,
            'password' => $request->password
        ], $request->remember)) {
            return back()->withErrors([
                'login_field' => 'Email / Phone or password is incorrect'
            ]);
        }

        $request->session()->regenerate();

        // 🔥 PHẦN QUAN TRỌNG
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
