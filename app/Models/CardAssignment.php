<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardAssignment extends Model
{
    protected $fillable = ['attendant_id', 'card_id', 'assigned_from', 'assigned_to'];

    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
