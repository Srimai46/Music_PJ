<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAddOn extends Model
{
    protected $table = 'booking_addons';
    protected $primaryKey = null; // เพราะ primary key เป็น composite (booking_id + instrument_id)
    public $incrementing = false; // ไม่ auto increment
    public $timestamps = false;

    protected $fillable = ['booking_id', 'instrument_id', 'quantity', 'price'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id', 'instrument_id');
    }
}
