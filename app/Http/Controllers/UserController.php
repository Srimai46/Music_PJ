<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function home()
    {
        // เรียกไฟล์ view/user/home.blade.php
        return view('user.home');
    }

    // แสดงหน้า edit profile
    public function editProfile() {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // บันทึกข้อมูลที่แก้ไข
    public function updateProfile(Request $request) {
        $user = Auth::user();

        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname'  => 'required|string|max:100',
            'username'  => 'required|string|max:50|unique:users,username,' . $user->user_id . ',user_id',
            'email'     => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'phone'     => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // ถ้ามีการกรอก current_password และ new_password
        if ($request->current_password && $request->new_password) {
            if (!Hash::check($request->current_password, $user->password_hash)) {
                return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
            }
            $user->password_hash = Hash::make($request->new_password);
        }

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->username  = $request->username;
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        /** @var User $user */
        $user->save();

        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
