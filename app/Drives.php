<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drives extends Model
{
     public function accountinfo()
    {
       return $this->hasMany(Accountinfo::class, 'HARDWARE_ID', 'HARDWARE_ID'); 
    }

     public function hardwares()
    {
       return $this->hasMany(Hardwares::class, 'ID', 'HARDWARE_ID'); 
    }
    
    public function getTotalAttribute($value){
        return round($value/1024,2);
    }
    public function getFreeAttribute($value){
        return round($value/1024,2);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('TYPE', $type);
    }
}
