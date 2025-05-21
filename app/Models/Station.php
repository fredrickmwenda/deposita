<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'station_admin_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function stationAdmin()
    {
        return $this->belongsTo(User::class, 'station_admin_id');
    }
}
