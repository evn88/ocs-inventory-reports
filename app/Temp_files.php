<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Temp_files extends Model
{
    protected $fillable = ['ID', 'FILE_NAME', 'FILE_TYPE'];
    protected $guarded = array('file');

    public function hardwares()
    {
        return $this->hasMany(Hardwares::class, 'ID','ID_DDE');
    }
    
   /* public function getLicenseImage($id)
    {
        Storage::makeDirectory('license/'.$id);
        $img = DB::table('temp_files')->select('id', 'FILE_NAME','FILE_TYPE','FILE_SIZE')->where('id', $id)->get();

        if (Storage::exists('license/'.$id.'/'.$img[0]->FILE_NAME))
        {
          $file = Storage::get('license/'.$id.'/'.$img[0]->FILE_NAME);
        }
        else 
        {
          $file = DB::table('temp_files')->select('file')->where('id', $id)->first();
          //$file = Image::make(file->file);

          Storage::put('license/'.$id.'/'.$img[0]->FILE_NAME, $file);
        }
        
        
        if ($img) 
        {
            return( '<img src="data:'.$img[0]->FILE_TYPE.';base64,' .base64_encode($file). '" alt="'.$img[0]->FILE_NAME.'">');
        } else
        {
            
        }
        
    }*/
}
