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
    //get the card number of an attendant that is active in cardAssignment
    public function activeCardNumber(){
        $assigned_card = CardAssignment::where('attendant_id', $this->id)->where('status', 'active')->first();
        if($assigned_card){
            $card = Card::where('id', $assigned_card->card_id)->first();
    
        $active_card = $card->number;
            return $active_card;
        }else{
            return 0;
        }
       return null;

    }
}
