<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'promo_id';
    protected $fillable = [
        'name', 'description', 'discount_type', 'discount_value',
        'start_date', 'end_date', 'is_active'
    ];
    public $timestamps = false;
}
