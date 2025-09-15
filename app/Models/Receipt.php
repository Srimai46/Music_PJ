<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receipt extends Model
{
    use HasFactory;

    protected $primaryKey = 'receipt_id'; // ตาม database
    public $timestamps = false; // มี created_at แต่ไม่มี updated_at

    protected $fillable = [
        'booking_id',
        'receipt_number',
        'full_amount',
        'deposit_amount',
        'discount_amount',
    ];

    // ความสัมพันธ์กับ Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}
