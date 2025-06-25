<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['number'];

    public function assignments()
    {
        return $this->hasMany(CardAssignment::class);
    }
}
