<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\User;
use App\Models\Promotion;
use App\Models\BookingAddon;
use App\Models\Payment;
use App\Models\Receipt;


class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'room_id',
        'promo_id',
        'start_time',
        'end_time',
        'total_price',
        'deposit_price',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship กับ User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship กับ Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    // Relationship กับ Promotion
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promo_id');
    }

    // Relationship กับ Add-ons
    public function addons()
    {
        return $this->hasMany(BookingAddon::class, 'booking_id');
    }

    // Relationship กับ Payment (1 booking มี 1 payment)
    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'booking_id');
    }

    // Relationship กับ Receipt (1 booking มี 1 receipt)
    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'booking_id', 'booking_id');
    }
}
