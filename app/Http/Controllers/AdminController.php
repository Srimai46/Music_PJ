<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Promotion;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // เรียกไฟล์ view/admin/dashboard.blade.php
        return view('admin.dashboard');
    }

    // -------------------------- User Management Section -------------------------- //
    public function userManagement()
    {
        $users = \App\Models\User::all(); // ดึงข้อมูลผู้ใช้ทั้งหมด
        return view('admin.userManage.userManagement', compact('users'));
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.userManage.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',user_id',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only('firstname', 'lastname', 'username', 'email', 'phone', 'role'));

        return redirect()->route('admin.userManagement')->with('success', 'อัพเดทข้อมูลผู้ใช้เรียบร้อยแล้ว');
    }
    
    public function resetPassword($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->password_hash = \Hash::make('12345678'); 
        $user->save();

        return redirect()->route('admin.userManagement')->with('success', 'รีเซ็ตรหัสผ่านเป็น "12345678" แล้ว');
    }

    // -------------------------- Rooms Section -------------------------- //
    public function rooms()
    {
        $rooms = Room::all();
        return view('admin.roomManage.rooms', compact('rooms'));
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity'       => 'required|integer|min:1',
            'description'    => 'nullable|string',
            'image_url'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only('name', 'price_per_hour', 'capacity', 'description');

        // ถ้ามีการอัปโหลดรูป
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('rooms', 'public');
            $data['image_url'] = $path;
        }

        Room::create($data);

        return redirect()->route('admin.rooms')->with('success', 'เพิ่มห้องซ้อมเรียบร้อยแล้ว');
    }

    public function editRoom($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.roomManage.editRoom', compact('room'));
    }

    public function updateRoom(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity'       => 'required|integer|min:1',
            'description'    => 'nullable|string',
            'image_url'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only('name', 'price_per_hour', 'capacity', 'description');

        // ถ้ามีการอัปโหลดรูปใหม่
        if ($request->hasFile('image_url')) {
            // ลบไฟล์เก่าออกก่อน (ถ้ามี)
            if ($room->image_url && Storage::disk('public')->exists($room->image_url)) {
                Storage::disk('public')->delete($room->image_url);
            }
            $path = $request->file('image_url')->store('rooms', 'public');
            $data['image_url'] = $path;
        }

        $room->update($data);

        return redirect()->route('admin.rooms')->with('success', 'แก้ไขข้อมูลห้องเรียบร้อยแล้ว');
    }

    public function deleteRoom($id)
    {
        $room = Room::findOrFail($id);

        // ลบไฟล์รูปออกด้วย
        if ($room->image_url && Storage::disk('public')->exists($room->image_url)) {
            Storage::disk('public')->delete($room->image_url);
        }

        $room->delete();

        return redirect()->route('admin.rooms')->with('success', 'ลบห้องเรียบร้อยแล้ว');
    }

    // -------------------------- Promotions Section -------------------------- //
    public function promotions()
    {
        $promotions = Promotion::orderBy('start_date', 'desc')->get();
        return view('admin.promotionManage.promotions', compact('promotions'));
    }

    public function createPromotion()
    {
        return view('admin.promotionManage.createPromotion'); // หน้าเพิ่มโปรโมชั่น
    }

    public function storePromotion(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Promotion::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
        ]);

        return redirect()->route('admin.promotions')->with('success', 'เพิ่มโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function editPromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('admin.promotionManage.editPromotion', compact('promotion'));
    }

    public function updatePromotion(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $promotion->update([
            'name' => $request->name,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.promotions')->with('success', 'แก้ไขโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function deletePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return redirect()->route('admin.promotions')->with('success', 'ลบโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function togglePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return redirect()->route('admin.promotions')->with('success', 'อัปเดตสถานะโปรโมชั่นเรียบร้อยแล้ว');
    }

    // -------------------------- Instruments Section -------------------------- //
    public function instruments()
    {
        // เรียกไฟล์ view/admin/instruments.blade.php
        return view('admin.instruments');
    }
    public function log()
    {
        // เรียกไฟล์ view/admin/log.blade.php
        return view('admin.log');
    }


    public function editProfile()
    {
        $admin = auth()->user(); // ตรวจสอบว่าเป็น admin ด้วย middleware
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $admin->user_id . ',user_id',
            'email' => 'required|email|unique:users,email,' . $admin->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // อัพเดทข้อมูลทั่วไป
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->phone = $request->phone;

        // เปลี่ยนรหัสผ่านถ้ามี
        if ($request->new_password) {
            if (Hash::check($request->current_password, $admin->password_hash)) {
                $admin->password_hash = Hash::make($request->new_password);
            } else {
                return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
            }
        }

        $admin->save();

        return back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
