<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    protected $table = 'instruments';
    protected $primaryKey = 'instrument_id';
    public $timestamps = false;

    protected $fillable = ['category_id','code','name','brand','picture_url','status'];

    public function category()
    {
        return $this->belongsTo(InstrumentCategory::class, 'category_id', 'category_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_instruments', 'instrument_id', 'room_id')
                    ->withPivot('quantity');
    }
}