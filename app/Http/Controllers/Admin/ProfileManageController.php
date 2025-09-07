<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileManageController extends Controller
{
    // -------------------------- Profile Setting Section -------------------------- //
    public function editProfile()
    {
        $admin = Auth::user(); 
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        
        $admin = Auth::user();

        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // อัพเดทข้อมูลทั่วไป
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->phone = $request->phone;

        // เปลี่ยนรหัสผ่านถ้ามี
        if ($request->new_password) {
            if (!$request->current_password) {
                return back()->withErrors(['current_password' => 'กรุณากรอกรหัสผ่านปัจจุบัน']);
            }

            if (Hash::check($request->current_password, $admin->password)) {
                $admin->password = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
            }
        }
        /** @var User $admin */
        $admin->save();

        return back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
