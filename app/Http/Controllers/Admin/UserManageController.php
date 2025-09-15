<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserManageController extends Controller
{
    // -------------------------- User Management Section -------------------------- //
    public function userManagement()
    {
        $users = User::all(); // ดึงข้อมูลผู้ใช้ทั้งหมด
        return view('admin.userManage.userManagement', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.userManage.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',user_id',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
        ]);

        $oldData = $user->toArray();

        $user->update($request->only('firstname', 'lastname', 'username', 'email', 'phone', 'role'));

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'role'       => 'admin',
            'action_type'=> 'update_user',
            'details'    => sprintf(
                "แก้ไขผู้ใช้ [ID: %d] จาก [ชื่อ: %s %s, Username: %s, Email: %s, เบอร์: %s, Role: %s] → [ชื่อ: %s %s, Username: %s, Email: %s, เบอร์: %s, Role: %s]",
                $user->user_id,
                $oldData['firstname'], $oldData['lastname'], $oldData['username'], $oldData['email'], $oldData['phone'] ?? '-', $oldData['role'],
                $user->firstname, $user->lastname, $user->username, $user->email, $user->phone ?? '-', $user->role
            ),
        ]);

        return redirect()->route('admin.userManagement')
                         ->with('success', 'อัพเดทข้อมูลผู้ใช้เรียบร้อยแล้ว');
    }
    
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password_hash = Hash::make('12345678'); 
        $user->save();

        ActivityLog::create([
            'user_id'    => auth()->id(),
            'role'       => 'admin',
            'action_type'=> 'reset_password',
            'details'    => "รีเซ็ตรหัสผ่านผู้ใช้ [ID: {$user->user_id}, Username: {$user->username}] เป็นค่าเริ่มต้นใหม่",
        ]);

        return redirect()->route('admin.userManagement')
                         ->with('success', 'รีเซ็ตรหัสผ่านเป็น "12345678" แล้ว');
    }
}
