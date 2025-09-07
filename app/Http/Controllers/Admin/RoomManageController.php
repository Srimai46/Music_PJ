<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Instrument;
use Illuminate\Support\Facades\Storage;

class RoomManageController extends Controller
{
    public function rooms()
    {
        $rooms = Room::all();
        return view('admin.roomManage.rooms', compact('rooms'));
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100|unique:rooms,name',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity'       => 'required|integer|min:1',
            'description'    => 'nullable|string|max:500',
            'image_url'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
        ], [
            'name.required'           => 'กรุณากรอกชื่อห้อง',
            'name.max'                => 'ชื่อห้องต้องไม่เกิน 100 ตัวอักษร',
            'name.unique'             => 'ชื่อห้องนี้มีอยู่แล้ว โปรดเปลี่ยนชื่อ',
            'price_per_hour.required' => 'กรุณากรอกราคาต่อชั่วโมง',
            'price_per_hour.numeric'  => 'ราคาต้องเป็นตัวเลข',
            'price_per_hour.min'      => 'ราคาต้องไม่น้อยกว่า 0',
            'capacity.required'       => 'กรุณากรอกจำนวนผู้ใช้สูงสุด',
            'capacity.integer'        => 'จำนวนผู้ใช้ต้องเป็นจำนวนเต็ม',
            'capacity.min'            => 'จำนวนผู้ใช้ต้องไม่น้อยกว่า 1',
            'description.string'      => 'คำอธิบายต้องเป็นข้อความ',
            'description.max'         => 'คำอธิบายต้องไม่เกิน 500 ตัวอักษร',
            'image_url.image'         => 'ไฟล์ต้องเป็นรูปภาพ',
            'image_url.mimes'         => 'ไฟล์รูปภาพต้องเป็น jpg, jpeg หรือ png',
            'image_url.max'           => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 5MB',
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
            'name' => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // ขนาดสูงสุด 5MB
        ], [
            'name.required' => 'กรุณากรอกชื่อห้อง',
            'name.string' => 'ชื่อห้องต้องเป็นข้อความ',
            'name.max' => 'ชื่อห้องต้องไม่เกิน 100 ตัวอักษร',
            'price_per_hour.required' => 'กรุณากรอกราคา/ชั่วโมง',
            'price_per_hour.numeric' => 'ราคา/ชั่วโมงต้องเป็นตัวเลข',
            'price_per_hour.min' => 'ราคา/ชั่วโมงต้องไม่เป็นค่าลบ',
            'capacity.required' => 'กรุณากรอกจำนวนคน',
            'capacity.integer' => 'จำนวนคนต้องเป็นจำนวนเต็ม',
            'capacity.min' => 'จำนวนคนต้องมากกว่า 0',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
            'description.max' => 'คำอธิบายต้องไม่เกิน 500 ตัวอักษร',
            'image_url.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'image_url.mimes' => 'ไฟล์รูปต้องเป็น jpg, jpeg หรือ png',
            'image_url.max' => 'ไฟล์รูปต้องมีขนาดไม่เกิน 5MB',
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

    // Adding Instrument to Rooms
    // แสดงเครื่องดนตรีทั้งหมดในห้อง
    public function showRoomInstruments($roomId)
    {
        $room = Room::with('instruments')->findOrFail($roomId);
        $instruments = Instrument::all(); // สำหรับเลือกเพิ่มใหม่
        return view('admin.roomManage.room_instruments', compact('room', 'instruments'));
    }

    // เพิ่มเครื่องดนตรีให้ห้อง
    public function addInstrumentToRoom(Request $request, $roomId)
    {
        $request->validate([
            'instrument_id' => 'required|exists:instruments,instrument_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($roomId);

        // ตรวจสอบ duplicate
        if ($room->instruments()->where('room_instruments.instrument_id', $request->instrument_id)->exists()) {
            return redirect()->back()->withErrors(['duplicate' => 'เครื่องดนตรีนี้มีอยู่ในห้องแล้ว']);
        }

        // เพิ่ม pivot table
        $room->instruments()->attach($request->instrument_id, ['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'เพิ่มเครื่องดนตรีให้ห้องเรียบร้อยแล้ว');
    }

    // อัปเดตจำนวนเครื่องดนตรีในห้อง
    public function updateRoomInstrument(Request $request, $roomId, $instrumentId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($roomId);
        $room->instruments()->updateExistingPivot($instrumentId, [
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'อัปเดตจำนวนเครื่องดนตรีเรียบร้อยแล้ว');
    }

    // ลบเครื่องดนตรีออกจากห้อง
    public function detachInstrumentFromRoom($roomId, $instrumentId)
    {
        $room = Room::findOrFail($roomId);
        $room->instruments()->detach($instrumentId);

        return back()->with('success', 'ลบเครื่องดนตรีออกจากห้องเรียบร้อยแล้ว');
    }
}
