<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Promotion;
use App\Models\Instrument;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\BookingAddon;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
                            ->orderBy('start_time', 'desc')
                            ->paginate(5); // Pagination 5 ต่อหน้า
        return view('user.bookings_history', compact('bookings'));
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'This action is unauthorized.');
        }

        return view('user.bookings_edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $start = $request->start_time;
        $end = $request->end_time;

        // ตรวจสอบ conflict กับ booking อื่นในห้องเดียวกัน (ยกเว้น booking ปัจจุบัน)
        $conflict = Booking::where('room_id', $booking->room_id)
                    ->where('status', 'confirmed')
                    ->where('booking_id', '<>', $booking->booking_id) // ยกเว้น booking ปัจจุบัน
                    ->where(function($q) use ($start, $end) {
                        $q->whereBetween('start_time', [$start, $end])
                        ->orWhereBetween('end_time', [$start, $end])
                        ->orWhere(function($q2) use ($start, $end) {
                            $q2->where('start_time', '<=', $start)
                                ->where('end_time', '>=', $end);
                        });
                    })
                    ->exists();

        if ($conflict) {
            return back()->withErrors(['time_conflict' => 'ช่วงเวลาที่เลือกชนกับการจองอื่นในห้องนี้']);
        }

        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        $booking->save();

        return redirect()->route('user.bookings')->with('success', 'Booking updated successfully.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status === 'cancelled') {
            abort(403, 'This action is unauthorized.');
        }

        // เงื่อนไขการยกเลิก
        $now = Carbon::now();
        $startTime = Carbon::parse($booking->start_time);
        $hoursBefore = $startTime->diffInHours($now, false);
        $refundPercent = ($hoursBefore >= 24) ? 80 : 50; // ยกตัวอย่าง
        $booking->status = 'cancelled';
        $booking->save();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'role' => 'user',
            'action_type' => 'cancel_booking',
            'details' => "ยกเลิกการจอง #{$booking->booking_id} คืนเงิน {$refundPercent}%",
        ]);

        return redirect()->route('user.bookings')->with('success', 'Booking cancelled successfully.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // เก็บ booking_id ไว้ใช้ใน log ก่อนลบ
        $bookingId = $booking->booking_id;

        // ลบข้อมูลที่เกี่ยวข้อง
        BookingAddon::where('booking_id', $bookingId)->delete();
        Payment::where('booking_id', $bookingId)->delete();
        Receipt::where('booking_id', $bookingId)->delete();

        // ลบ booking
        $booking->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'role' => auth()->user()->role,
            'action_type' => 'delete_booking',
            'details' => "ลบการจอง #{$bookingId} และข้อมูลที่เกี่ยวข้องทั้งหมด",
        ]);

        return redirect()->route('user.bookings')->with('success', 'Booking deleted successfully.');
    }

    // ---------------------------------- Rooms Info ----------------------------------- //
    public function roomInfo(Room $room)
    {
        // ดึง booking ของห้องนี้ทั้งหมด
        $bookings = $room->bookings()->where('status', 'confirmed')->get();

        // ดึงโปรโมชั่นที่ยัง active
        $promotions = Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        return view('user.roominfo', compact('room', 'bookings', 'promotions'));
    }

    public function checkAvailability(Request $request, Room $room)
    {
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $start = $request->start_time;
        $end = $request->end_time;

        $conflict = $room->bookings()
            ->where('status', 'confirmed')
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                ->orWhereBetween('end_time', [$start, $end])
                ->orWhere(function($q2) use ($start, $end) {
                    $q2->where('start_time', '<=', $start)
                        ->where('end_time', '>=', $end);
                });
            })
            ->exists();

        $hours = ceil((strtotime($end) - strtotime($start)) / 3600);
        $price = $room->price_per_hour * $hours;

        // ใช้โปรโมชั่นล่าสุดถ้ามี
        $promo = Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->latest('discount_value')
            ->first();

        $discount_amount = 0;
        if ($promo) {
            if ($promo->discount_type == 'percent') {
                $discount_amount = $price * ($promo->discount_value / 100);
            } else {
                $discount_amount = $promo->discount_value;
            }
        }

        $total = max($price - $discount_amount, 0);

        return response()->json([
            'conflict' => $conflict,
            'hours' => $hours,           // จำนวนชั่วโมง
            'price' => $price,           // numeric
            'discount' => $discount_amount, // numeric
            'total' => $total,           // numeric
            'promo_name' => $promo?->name
        ]);
    }

    // ---------------------------------- Room AddOn ----------------------------------- //
    public function roomAddon(Request $request, Room $room)
    {
        // รับค่าที่ส่งมาจาก roominfo
        $hours = $request->query('hours');
        $total = $request->query('total');
        $start_time = $request->query('start_time');
        $end_time = $request->query('end_time');

        // ดึงรายการเครื่องดนตรีทั้งหมด (ให้ user เลือก Add-on)
        $instruments = Instrument::where('status', 'available')->get();

        return view('user.room_addon', compact('room', 'hours', 'total', 'start_time', 'end_time', 'instruments'));
    }

    public function calculateAddon(Request $request, Room $room)
    {
        $validated = $request->validate([
            'addons' => 'array',
            'addons.*.instrument_id' => 'required|integer|exists:instruments,instrument_id',
            'addons.*.quantity' => 'required|integer|min:1',
            'base_total' => 'required|numeric|min:0',
        ]);

        $addons = $validated['addons'] ?? [];
        $addon_total = 0;

        foreach ($addons as $addon) {
            $instrument = Instrument::find($addon['instrument_id']);
            if ($instrument && $instrument->status === 'available') {
                $addon_total += $instrument->price_per_unit * $addon['quantity'];
            }
        }

        $final_total = $validated['base_total'] + $addon_total;

        return response()->json([
            'addon_total' => $addon_total,
            'final_total' => $final_total,
        ]);
    }

    // ---------------------------------- Payment ----------------------------------- //
    public function payment(Request $request, $room_id)
    {
        $room = \App\Models\Room::with('instruments')->findOrFail($room_id);

        // รับค่าจาก room_addon
        $base_total = $request->query('base_total');
        $addon_total = $request->query('addon_total');
        $final_total = $request->query('final_total');
        $hours = $request->query('hours');
        $start_time = $request->query('start_time');
        $end_time = $request->query('end_time');

        // คำนวณราคามัดจำ (50%)
        $deposit = $final_total * 0.5;

        // รับ addons (array)
        $addons = json_decode($request->query('addons', '[]'), true);
        if (!is_array($addons)) {
            $addons = [];
        }

        return view('user.payment', compact(
            'room',
            'base_total',
            'addon_total',
            'final_total',
            'deposit',
            'hours',
            'start_time',
            'end_time',
            'addons'
        ));
    }

    public function showQRCode(Request $request, $room_id)
    {
        $room = \App\Models\Room::with('instruments')->findOrFail($room_id);

        // รับค่าจาก POST form
        $hours = $request->input('hours');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $final_total = $request->input('final_total');


        $addons = $request->input('addons', '[]');
        $addons = json_decode($addons, true);

        if (!is_array($addons)) $addons = [];

        // แก้ key ให้ uniform
        foreach ($addons as &$addon) {
            if (isset($addon['id'])) {
                $addon['instrument_id'] = $addon['id'];
            }
            if (isset($addon['qty'])) {
                $addon['quantity'] = $addon['qty'];
            }
        }
        unset($addon);



        $deposit = $final_total * 0.5;

        return view('user.qrcode', compact(
            'room', 'hours', 'start_time', 'end_time', 'final_total', 'addons', 'deposit'
        ));
    }

    // ---------------------------------- Confirm Payment ----------------------------------- //
    public function confirmPayment(Request $request, $room_id)
    {
        $room = \App\Models\Room::findOrFail($room_id);

        // รับค่าจาก hidden input หรือ form
        $hours = $request->input('hours');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $final_total = $request->input('final_total');
        $addon_data = $request->input('addons', []); // array: [instrument_id => quantity]

        // คำนวณ deposit
        $deposit = $final_total * 0.5;

        // สร้าง Booking
        $booking = new \App\Models\Booking();
        $booking->user_id = auth()->id();
        $booking->room_id = $room_id;
        $booking->start_time = $start_time;
        $booking->end_time = $end_time;
        $booking->total_price = $final_total;
        $booking->deposit_price = $deposit;
        $booking->status = 'confirmed';
        $booking->save();

        // บันทึก Add-ons
        if (!empty($addon_data) && is_array($addon_data)) {
            foreach ($addon_data as $instrument_id => $qty) {
                $instrument = \App\Models\Instrument::find($instrument_id);
                if ($instrument && $qty > 0) {
                    \App\Models\BookingAddon::create([
                        'booking_id'   => $booking->booking_id,
                        'instrument_id'=> $instrument_id,
                        'quantity'     => $qty,
                        'price'        => $instrument->price_per_unit
                    ]);
                }
            }
        }

        // สร้าง Payment record
        \App\Models\Payment::create([
            'booking_id' => $booking->booking_id,
            'amount' => $deposit,
            'payment_method' => 'qr_code',
            'payment_status' => 'paid',
            'transaction_id' => 'TXN'.time(),
            'paid_at' => now()
        ]);

        // สร้าง Receipt
        \App\Models\Receipt::create([
            'booking_id' => $booking->booking_id,
            'receipt_number' => str_pad($booking->booking_id, 5, '0', STR_PAD_LEFT),
            'full_amount' => $final_total,
            'deposit_amount' => $deposit,
            'discount_amount' => 0 // ปรับตามระบบโปรโมชั่นถ้ามี
        ]);

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'role' => 'user',
            'action_type' => 'confirm_payment',
            'details' => "Booking #".str_pad($booking->booking_id,5,'0',STR_PAD_LEFT)." confirmed via QR Code"
        ]);

        // return redirect()->route('user.bookings')->with('success', 'Booking confirmed successfully!');
        return redirect()->route('user.room.receipt', $booking->booking_id)->with('success', 'Payment confirmed successfully!');
    }

    // ---------------------------------- Receipt ----------------------------------- //
    public function showReceipt(Booking $booking)
    {
        // ตรวจสอบสิทธิ์ user
        if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // ดึงข้อมูล Payment
        $payment = $booking->payment()->first();

        // ดึง Add-ons
        $addons = $booking->addons()->with('instrument')->get();

        // ดึง Receipt หรือสร้างใหม่ถ้ายังไม่มี
        $receipt = $booking->receipt()->first();
        if (!$receipt) {
            $receipt_number = 'R'.str_pad($booking->booking_id, 5, '0', STR_PAD_LEFT).time();
            $receipt = \App\Models\Receipt::create([
                'booking_id' => $booking->booking_id,
                'receipt_number' => $receipt_number,
                'full_amount' => $booking->total_price,
                'deposit_amount' => $booking->deposit_price,
                'discount_amount' => $booking->promo?->discount_value ?? 0,
            ]);
        }

        return view('user.receipt', compact('booking', 'payment', 'addons', 'receipt'));
    }

    // สำหรับ Export PDF
    public function exportReceiptPDF(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $payment = $booking->payment()->first();
        $addons = $booking->addons()->with('instrument')->get();
        $receipt = $booking->receipt()->first();

        $pdf = Pdf::loadView('user.receipt_pdf', compact('booking', 'payment', 'addons', 'receipt'));
        return $pdf->download("Receipt_{$receipt->receipt_number}.pdf");
    }

    // ---------------------------------- Admin Statue Edit ----------------------------------- //
    public function updateStatus(Request $request, Booking $booking)
    {
        // Validate input
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,complete'
        ]);

        $oldStatus = $booking->status;
        $booking->status = $request->status;
        $booking->save();

        // Log activity (ถ้ามี ActivityLog)
        ActivityLog::create([
            'user_id' => auth()->id(),
            'role' => 'admin',
            'action_type' => 'Update Booking Status',
            'details' => "Booking ID {$booking->id} status changed from {$oldStatus} to {$booking->status}",
        ]);

        return back()->with('success', "Booking status updated successfully.");
    }

}
