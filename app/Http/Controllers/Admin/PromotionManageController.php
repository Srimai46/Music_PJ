<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Models\Promotion;

class PromotionManageController extends Controller
{
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
            'name' => 'required|string|max:100|unique:promotions,name',
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => ['required','numeric','min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 100) {
                        $fail('ส่วนลดแบบเปอร์เซ็นต์ต้องไม่เกิน 100');
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'name.required' => 'กรุณากรอกชื่อโปรโมชั่น',
            'name.max' => 'ชื่อโปรโมชั่นต้องไม่เกิน 100 ตัวอักษร',
            'name.unique' => 'ชื่อโปรโมชั่นนี้มีอยู่แล้ว',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
            'description.max' => 'คำอธิบายต้องไม่เกิน 500 ตัวอักษร',
            'discount_type.required' => 'กรุณาเลือกประเภทส่วนลด',
            'discount_type.in' => 'ประเภทส่วนลดต้องเป็น percent หรือ fixed',
            'discount_value.required' => 'กรุณากรอกจำนวนส่วนลด',
            'discount_value.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'discount_value.min' => 'จำนวนส่วนลดต้องไม่น้อยกว่า 0',
            'start_date.required' => 'กรุณาเลือกวันเริ่มต้นโปรโมชั่น',
            'start_date.date' => 'วันเริ่มต้นไม่ถูกต้อง',
            'end_date.required' => 'กรุณาเลือกวันสิ้นสุดโปรโมชั่น',
            'end_date.date' => 'วันสิ้นสุดไม่ถูกต้อง',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่ก่อนวันเริ่มต้น',
        ]);

        $promotion = Promotion::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
        ]);

        // บันทึก Activity Log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'create_promotion',
            'details' => "สร้างโปรโมชั่น [{$promotion->name}] (ประเภท: {$promotion->discount_type}, ส่วนลด: {$promotion->discount_value})",
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
        $oldData = $promotion->toArray();

        $request->validate([
            'name' => 'required|string|max:100|unique:promotions,name,' . $id . ',promo_id',
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => ['required','numeric','min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 100) {
                        $fail('ส่วนลดแบบเปอร์เซ็นต์ต้องไม่เกิน 100');
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'กรุณากรอกชื่อโปรโมชั่น',
            'name.max' => 'ชื่อโปรโมชั่นต้องไม่เกิน 100 ตัวอักษร',
            'name.unique' => 'ชื่อโปรโมชั่นนี้มีอยู่แล้ว',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
            'description.max' => 'คำอธิบายต้องไม่เกิน 500 ตัวอักษร',
            'discount_type.required' => 'กรุณาเลือกประเภทส่วนลด',
            'discount_type.in' => 'ประเภทส่วนลดต้องเป็น percent หรือ fixed',
            'discount_value.required' => 'กรุณากรอกจำนวนส่วนลด',
            'discount_value.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'discount_value.min' => 'จำนวนส่วนลดต้องไม่น้อยกว่า 0',
            'start_date.required' => 'กรุณาเลือกวันเริ่มต้นโปรโมชั่น',
            'start_date.date' => 'วันเริ่มต้นไม่ถูกต้อง',
            'end_date.required' => 'กรุณาเลือกวันสิ้นสุดโปรโมชั่น',
            'end_date.date' => 'วันสิ้นสุดไม่ถูกต้อง',
            'end_date.after_or_equal' => 'วันสิ้นสุดต้องไม่ก่อนวันเริ่มต้น',
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

        // บันทึก Activity Log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'update_promotion',
            'details' => "แก้ไขโปรโมชั่น [{$oldData['name']}] → [{$promotion->name}], 
                        ส่วนลด: {$oldData['discount_value']} → {$promotion->discount_value}, 
                        สถานะ: " . ($oldData['is_active'] ? 'Active' : 'Inactive') . " → " . ($promotion->is_active ? 'Active' : 'Inactive'),
        ]);

        return redirect()->route('admin.promotions')->with('success', 'แก้ไขโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function deletePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $name = $promotion->name;
        $promotion->delete();

        // บันทึก Activity Log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'delete_promotion',
            'details' => "ลบโปรโมชั่น [{$name}]",
        ]);

        return redirect()->route('admin.promotions')->with('success', 'ลบโปรโมชั่นเรียบร้อยแล้ว');
    }

    public function togglePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        // บันทึก Activity Log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'toggle_promotion',
            'details' => "สลับสถานะโปรโมชั่น [{$promotion->name}] เป็น " . ($promotion->is_active ? 'Active' : 'Inactive'),
        ]);

        return redirect()->route('admin.promotions')->with('success', 'อัปเดตสถานะโปรโมชั่นเรียบร้อยแล้ว');
    }

}
