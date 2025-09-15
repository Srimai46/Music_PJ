<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Promotion;
use App\Models\ActivityLog;

class UserController extends Controller
{
    public function home(Request $request)
    {
        // ดึงโปรโมชั่นที่ยัง active
        $promotions = Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        // Query ห้อง
        $query = Room::with('instruments');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter ตาม capacity
        if ($request->filled('capacity')) {
            $query->where('capacity', '>=', $request->capacity);
        }

        // Filter ตามราคา
        if ($request->filled('min_price')) {
            $query->where('price_per_hour', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_hour', '<=', $request->max_price);
        }

        // Filter ตามอุปกรณ์
        if ($request->filled('instrument_ids')) {
            $instrumentIds = $request->instrument_ids;
            $query->whereHas('instruments', function($q) use ($instrumentIds) {
                $q->whereIn('instrument_id', $instrumentIds);
            });
        }

        $rooms = $query->get();

        return view('user.home', compact('promotions', 'rooms'));
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

        // บันทึก Log
        ActivityLog::create([
            'user_id' => $user->user_id,
            'role' => 'user',
            'action_type' => 'update_profile',
            'details' => 'User updated profile information',
        ]);

        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
