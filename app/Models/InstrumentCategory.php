<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstrumentCategory extends Model
{
    protected $table = 'instrument_categories';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = ['name'];
}
