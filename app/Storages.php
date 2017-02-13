<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storages extends Model
{
    //protected $primaryKey = "ID";
    //protected $table = "storages";
    
    public function getDisksizeAttribute($value){
        return round($value/1024,2);
    }
}
