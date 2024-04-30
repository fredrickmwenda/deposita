<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DataStorage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'drop_data';
    // public static function insertData($data){
       
    //     $value = DB::table('data_storages')->where('Sequence', $data['Sequence'])->get();
    //     if($value->count() == 0){
    //         DB::table('csv_data')->insert($data);
    //     }

    //     // a shift belongs to an attendant
 
    // }

    public function Attendant()
    {
        return $this->belongsTo(Attendant::class, 'Card_id');
    }


}
