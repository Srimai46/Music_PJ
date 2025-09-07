<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    protected $fillable = [
        'name',
        'price_per_hour',
        'capacity',
        'description',
        'image_url',
    ];

    public $timestamps = false;

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'room_instruments', 'room_id', 'instrument_id')
                    ->withPivot('quantity');
    }
}
