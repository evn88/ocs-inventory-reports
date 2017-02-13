<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Accountinfo extends Model
{
    //protected $primaryKey = "HARDWARE_ID";
    protected $table = "accountinfo";

    
    public function GetFields9Attribute($value){
        
        return Carbon::parse($value)->format('Y');
    }
}
