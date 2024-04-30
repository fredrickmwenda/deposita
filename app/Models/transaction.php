<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'cashier_record';

    protected $casts = [
        'expected' => 'float',
    ];

    // transaction belongs to a DataStorage
    public function dataStorage()
    {
        return $this->hasMany(DataStorage::class);
    }

    public function attendant()
    {
        return $this->belongsTo(Attendant::class, 'attendant_id');
    }

    public function coins()
    {
        return $this->hasMany(Coin::class);
    }

    public function recoveries()
    {
        return $this->hasMany(Recovery::class);
    }
}
