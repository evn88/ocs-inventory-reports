<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{
    protected $primaryKey = "IVALUE";
    protected $table = "config";

    public function scopeApc($query, $id){
        return $query->where('NAME','like','ACCOUNT_VALUE_IBP_%')->where('IVALUE','=',$id);
    }
}
