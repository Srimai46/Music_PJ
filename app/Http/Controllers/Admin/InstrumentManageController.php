<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instrument;
use App\Models\InstrumentCategory;
use App\Models\Room;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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

        $category = InstrumentCategory::create(['name' => $request->name,]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'create_instrument_category',
            'details' => "เพิ่มประเภทเครื่องดนตรี [{$category->name}]",
        ]);

        return redirect()->route('admin.instrumentCategories')->with('success', 'เพิ่มประเภทเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function deleteSelectedInstrumentCategories(Request $request)
    {
        $ids = $request->ids;
        if(!$ids || !is_array($ids)){
            return response()->json(['success' => false]);
        }

        $categories = InstrumentCategory::whereIn('category_id', $ids)->get();

        // ลบเครื่องดนตรีใน category
        foreach($categories as $cat){
            Instrument::where('category_id', $cat->category_id)->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'role' => 'admin',
                'action_type' => 'delete_instrument_category',
                'details' => "ลบประเภทเครื่องดนตรี [{$cat->name}] และเครื่องดนตรีทั้งหมดใน category นี้",
            ]);
        }

        // // ลบเครื่องดนตรีใน category ที่เลือกด้วย (ถ้ามี)
        // \App\Models\Instrument::whereIn('category_id', $ids)->delete();

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
            'price_per_unit' => 'required|numeric|min:0',
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
            'price_per_unit.required' => 'กรุณากรอกราคาเครื่องดนตรีต่อหน่วย',
            'price_per_unit.numeric' => 'ราคาต้องเป็นตัวเลข',
            'price_per_unit.min' => 'ราคาต้องมากกว่าหรือเท่ากับ 0',
        ]);

        $data = $request->only('category_id','code','name','brand','status','price_per_unit');

        if ($request->hasFile('picture_url')) {
            $path = $request->file('picture_url')->store('instruments', 'public');
            $data['picture_url'] = $path;
        }

        $instrument = Instrument::create($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'create_instrument',
            'details' => "เพิ่มเครื่องดนตรี [{$instrument->name}] รหัส: {$instrument->code}",
        ]);

        return back()->with('success', 'เพิ่มเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function updateInstrument(Request $request, $id)
    {
        $instrument = Instrument::findOrFail($id);
        $oldData = $instrument->toArray();

        $request->validate([
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'status' => 'required|in:available,unavailable,maintenance',
            'price_per_unit' => 'required|numeric|min:0',
        ], [
            'name.required' => 'กรุณากรอกชื่อเครื่องดนตรี',
            'status.required' => 'กรุณาเลือกสถานะเครื่องดนตรี',
            'status.in' => 'สถานะเครื่องดนตรีไม่ถูกต้อง',
            'picture_url.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'picture_url.mimes' => 'รองรับเฉพาะไฟล์ jpg/jpeg/png',
            'picture_url.max' => 'ไฟล์รูปภาพไม่เกิน 5MB',
            'price_per_unit.required' => 'กรุณากรอกราคาเครื่องดนตรีต่อหน่วย',
            'price_per_unit.numeric' => 'ราคาต้องเป็นตัวเลข',
            'price_per_unit.min' => 'ราคาต้องมากกว่าหรือเท่ากับ 0',
        ]);

        $data = $request->only('name','brand','status','price_per_unit');

        if ($request->hasFile('picture_url')) {
            if ($instrument->picture_url && Storage::disk('public')->exists($instrument->picture_url)) {
                Storage::disk('public')->delete($instrument->picture_url);
            }
            $path = $request->file('picture_url')->store('instruments', 'public');
            $data['picture_url'] = $path;
        }

        $instrument->update($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'update_instrument',
            'details' => "แก้ไขเครื่องดนตรี [{$oldData['name']}] → [{$instrument->name}]",
        ]);

        return back()->with('success', 'แก้ไขข้อมูลเครื่องดนตรีเรียบร้อยแล้ว');
    }

    public function deleteInstrument($id)
    {
        $instrument = Instrument::findOrFail($id);
        $name = $instrument->name;
        $code = $instrument->code;

        if ($instrument->picture_url && Storage::disk('public')->exists($instrument->picture_url)) {
            Storage::disk('public')->delete($instrument->picture_url);
        }

        $instrument->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'delete_instrument',
            'details' => "ลบเครื่องดนตรี [{$name}] รหัส: {$code}",
        ]);

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

        $room = Room::find($request->room_id);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'add_room_to_instrument',
            'details' => "เพิ่มห้อง [{$room->name}] ให้เครื่องดนตรี [{$instrument->name}] จำนวน {$request->quantity}",
        ]);

        return redirect()->back()->with('success', 'เพิ่มห้องให้เครื่องดนตรีเรียบร้อยแล้ว');
    }

    // อัพเดทจำนวนเครื่องดนตรีใน pivot
    public function updateInstrumentRoom(Request $request, $instrumentId, $roomId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $instrument = Instrument::findOrFail($instrumentId);
        $oldQuantity = $instrument->rooms()->wherePivot('room_id', $roomId)->first()->pivot->quantity;
        $instrument->rooms()->updateExistingPivot($roomId, ['quantity' => $request->quantity]);
        $room = Room::find($roomId);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'update_instrument_room',
            'details' => "อัปเดตจำนวนเครื่องดนตรี [{$instrument->name}] ในห้อง [{$room->name}] จาก {$oldQuantity} → {$request->quantity}",
        ]);

        return back()->with('success', 'อัปเดตจำนวนเรียบร้อยแล้ว ✅');
    }

    // ลบห้องออกจากเครื่องดนตรี
    public function detachRoom($instrumentId, $roomId)
    {
        $instrument = Instrument::findOrFail($instrumentId);
        $room = Room::findOrFail($roomId);
        $instrument->rooms()->detach($roomId);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action_type' => 'detach_room_from_instrument',
            'details' => "ลบห้อง [{$room->name}] ออกจากเครื่องดนตรี [{$instrument->name}]",
        ]);

        return back()->with('success', 'ลบห้องออกเรียบร้อยแล้ว ❌');
    }
}
