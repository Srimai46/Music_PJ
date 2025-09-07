<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instrument;
use App\Models\InstrumentCategory;
use App\Models\Room;                        
use Illuminate\Support\Facades\Storage;      
use Illuminate\Support\Str;                  
use Illuminate\Validation\Rule;              

class InstrumentManageController extends Controller
{
    // -------------------------- Instruments Section -------------------------- //

    // Instruments Category
    public function instrumentCategories()
    {
        $categories = InstrumentCategory::all();
        return view('admin.instrumentManage.instrument_categories', compact('categories'));
    }

    public function storeInstrumentCategory(Request $request)
    {
        // ตัดช่องว่างก่อน validate
        $name = trim($request->name);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('instrument_categories')->where(function ($query) use ($name) {
                    return $query->whereRaw('LOWER(name) = ?', [Str::lower($name)]);
                }),
            ],
        ], [
            'name.required' => 'กรุณากรอกชื่อประเภทเครื่องดนตรี',
            'name.string'   => 'ชื่อประเภทเครื่องดนตรีต้องเป็นข้อความ',
            'name.max'      => 'ชื่อประเภทเครื่องดนตรีต้องไม่เกิน 100 ตัวอักษร',
            'name.unique'   => 'ประเภทเครื่องดนตรีนี้มีอยู่แล้ว',
        ]);

        InstrumentCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.instrumentCategories')->with('success', 'เพิ่มประเภทเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function deleteSelectedInstrumentCategories(Request $request)
    {
        $ids = $request->ids;
        if(!$ids || !is_array($ids)){
            return response()->json(['success' => false]);
        }

        // ลบเครื่องดนตรีใน category ที่เลือกด้วย (ถ้ามี)
        \App\Models\Instrument::whereIn('category_id', $ids)->delete();

        // ลบ category
        InstrumentCategory::whereIn('category_id', $ids)->delete();

        return response()->json(['success' => true]);
    }

    // Instruments By Category
    public function instrumentsByCategory($category_id)
    {
        $category = InstrumentCategory::findOrFail($category_id);
        $instruments = Instrument::where('category_id', $category_id)->get();
        return view('admin.instrumentManage.instruments', compact('category', 'instruments'));
    }

    public function storeInstrument(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:instrument_categories,category_id',
            'code' => 'required|string|max:20|unique:instruments,code',
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:available,unavailable,maintenance',
        ], [
            'category_id.required' => 'กรุณาเลือกประเภทเครื่องดนตรี',
            'category_id.exists' => 'ประเภทเครื่องดนตรีไม่ถูกต้อง',
            'code.required' => 'กรุณากรอกรหัสเครื่องดนตรี',
            'code.unique' => 'รหัสเครื่องดนตรีนี้มีอยู่แล้ว',
            'name.required' => 'กรุณากรอกชื่อเครื่องดนตรี',
            'status.required' => 'กรุณาเลือกสถานะเครื่องดนตรี',
            'status.in' => 'สถานะเครื่องดนตรีไม่ถูกต้อง',
            'picture_url.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'picture_url.mimes' => 'รองรับเฉพาะไฟล์ jpg/jpeg/png',
            'picture_url.max' => 'ไฟล์รูปภาพไม่เกิน 5MB',
        ]);

        $data = $request->only('category_id','code','name','brand','status');

        if ($request->hasFile('picture_url')) {
            $path = $request->file('picture_url')->store('instruments', 'public');
            $data['picture_url'] = $path;
        }

        Instrument::create($data);

        return back()->with('success', 'เพิ่มเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function updateInstrument(Request $request, $id)
    {
        $instrument = Instrument::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:available,unavailable,maintenance',
        ], [
            'name.required' => 'กรุณากรอกชื่อเครื่องดนตรี',
            'status.required' => 'กรุณาเลือกสถานะเครื่องดนตรี',
            'status.in' => 'สถานะเครื่องดนตรีไม่ถูกต้อง',
            'picture_url.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'picture_url.mimes' => 'รองรับเฉพาะไฟล์ jpg/jpeg/png',
            'picture_url.max' => 'ไฟล์รูปภาพไม่เกิน 5MB',
        ]);

        $data = $request->only('name','brand','status');

        if ($request->hasFile('picture_url')) {
            if ($instrument->picture_url && Storage::disk('public')->exists($instrument->picture_url)) {
                Storage::disk('public')->delete($instrument->picture_url);
            }
            $path = $request->file('picture_url')->store('instruments', 'public');
            $data['picture_url'] = $path;
        }

        $instrument->update($data);

        return back()->with('success', 'แก้ไขข้อมูลเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function deleteInstrument($id)
    {
        $instrument = Instrument::findOrFail($id);

        if ($instrument->picture_url && Storage::disk('public')->exists($instrument->picture_url)) {
            Storage::disk('public')->delete($instrument->picture_url);
        }

        $instrument->delete();

        return back()->with('success', 'ลบเครื่องดนตรีเรียบร้อยแล้ว');
    }

    // Rooms used by instrument
    public function showInstrument($id)
    {
        $instrument = Instrument::with('rooms')->findOrFail($id);
        return view('admin.instrumentManage.show', compact('instrument'));
    }

    public function addRoomToInstrument($instrumentId)
    {
        $instrument = Instrument::findOrFail($instrumentId);
        $rooms = Room::all(); // เลือกได้ทั้งหมด หรือจะกรองตามเงื่อนไข
        return view('admin.instrumentManage.addRoom', compact('instrument', 'rooms'));
    }

    public function storeInstrumentRoom(Request $request, $instrumentId)
    {
        $instrument = Instrument::findOrFail($instrumentId);

        // ✅ ใส่ validation และเช็ค duplicate
        $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'quantity' => 'required|integer|min:1',
        ], [
            'room_id.required' => 'กรุณาเลือกห้อง',
            'room_id.exists' => 'ห้องที่เลือกไม่ถูกต้อง',
            'quantity.required' => 'กรุณากรอกจำนวน',
            'quantity.min' => 'จำนวนต้องมากกว่า 0',
        ]);

        // ป้องกัน duplicate entry
        $exists = $instrument->rooms()->wherePivot('room_id', $request->room_id)->exists();
        if ($exists) {
            return back()
                ->withErrors(['room_id' => 'ห้องนี้มีอยู่แล้วสำหรับเครื่องดนตรีนี้'], 'instrumentRoom')
                ->withInput(['instrument_id' => $instrumentId, 'room_id' => $request->room_id, 'quantity' => $request->quantity]);
        }
        
        // หรือถ้า validation error จะถูก handle โดย Laravel อัตโนมัติ
        // ให้แน่ใจว่า old('instrument_id') ถูกตั้ง
        $request->merge(['instrument_id' => $instrumentId]);

        // เพิ่มห้องให้เครื่องดนตรี
        $instrument->rooms()->attach($request->room_id, ['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'เพิ่มห้องให้เครื่องดนตรีเรียบร้อยแล้ว');
    }

    // อัพเดทจำนวนเครื่องดนตรีใน pivot
    public function updateInstrumentRoom(Request $request, $instrumentId, $roomId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $instrument = Instrument::findOrFail($instrumentId);
        $instrument->rooms()->updateExistingPivot($roomId, [
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'อัปเดตจำนวนเรียบร้อยแล้ว ✅');
    }

    // ลบห้องออกจากเครื่องดนตรี
    public function detachRoom($instrumentId, $roomId)
    {
        $instrument = Instrument::findOrFail($instrumentId);
        $instrument->rooms()->detach($roomId);

        return back()->with('success', 'ลบห้องออกเรียบร้อยแล้ว ❌');
    }
}
