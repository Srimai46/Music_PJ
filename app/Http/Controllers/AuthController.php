<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Show login form
    public function loginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $loginInput = $request->login;

        $user = User::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if ($user && Hash::check($request->password, $user->password_hash)) {
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // ✅ ใช้ route name
            }
            return redirect()->route('user.home'); // ✅ ไป user home
        }

        return back()->withErrors(['login' => 'Username/Email หรือรหัสผ่านไม่ถูกต้อง']);
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout(); // ลบ session ของ Laravel Auth
        $request->session()->invalidate(); // ล้าง session ทั้งหมด
        $request->session()->regenerateToken(); // สร้าง CSRF token ใหม่
        return redirect('/'); // กลับหน้าแรก
    }

    // Show register form
    public function registerForm()
    {
        return view('auth.register');
    }

    // Handle register
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'nullable',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user'
        ]);

        session(['user_id' => $user->user_id, 'role' => $user->role]);
        return redirect('/login');
    }

    // Show forgot password form
    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Send reset link
    public function sendResetLink(Request $request)
    {
        // ตรวจสอบค่าอีเมล
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'ไม่พบอีเมลนี้ในระบบ']);
        }

        // สร้าง token
        $token = Str::random(64);
        PasswordReset::create([
            'user_id' => $user->user_id,
            'reset_token' => $token,
            'expires_at' => Carbon::now()->addMinutes(60),
            'used' => false
        ]);

        // **ข้ามการส่งอีเมล** → redirect ไปหน้า reset-password ทันที
        return redirect("/reset-password/{$token}");
    }

    // Show reset password form
    public function resetPasswordForm($token)
    {
        $reset = PasswordReset::where('reset_token', $token)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return redirect('/login')->withErrors(['token' => 'ลิงก์หมดอายุหรือใช้แล้ว']);
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    // Handle reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $reset = PasswordReset::where('reset_token', $request->token)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return redirect('/login')->withErrors(['token' => 'ลิงก์หมดอายุหรือใช้แล้ว']);
        }

        $user = $reset->user;
        $user->password_hash = Hash::make($request->password);
        $user->save();

        $reset->used = true;
        $reset->save();

        return redirect('/login')->with('success', 'รีเซ็ตรหัสผ่านสำเร็จ สามารถ Login ได้เลย');
    }
}
