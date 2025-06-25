<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'attendants';

    public function transactions()
    {
        return $this->hasMany(transaction::class, 'attendant_id');
    }
    public function recoveries()
    {
        return $this->hasMany(Recovery::class, 'attendant_id');
    }
    public function assignments()
    {
        return $this->hasMany(\App\Models\CardAssignment::class);
    }
}
