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

    public function scopeOfTag($query, $type)
    {
        return $query->where('TAG', $type);
    }

    public function scopeFilials($query)
    {
        $filials = [];
        foreach($query->get() as $q){
            if (!in_array($q->fields_4, $filials) && $q->fields_4 !==NULL){
                array_push($filials, $q->fields_4);
            }
        }
        return $filials;
    }

    public function apc()
    {
       return $this->hasOne(Configs::class, 'IVALUE', 'fields_30'); 
    }
}
