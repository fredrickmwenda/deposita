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

    protected $fillable = [
        'date',
        'shift',
        'expected',
        'total',
        'recovery',
        'attendant_id',
        'client_id',
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
