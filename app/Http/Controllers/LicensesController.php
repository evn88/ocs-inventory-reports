<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Temp_files; 

class LicensesController extends Controller
{
    /*
     * Загружаем изображение лицензии из базы для отдачи в браузер
     * для ajax
     */

    public function getLicenseImage($id)
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
          $file = $file->file;
          Storage::put('license/'.$id.'/'.$img[0]->FILE_NAME, $file);
        }
        
        
        if ($img) 
        {
            $data = json_encode(array(
                'id'=>$id,
                'name'=>$img[0]->FILE_NAME,
                'type'=>$img[0]->FILE_TYPE,
                'img' => 'data:'.$img[0]->FILE_TYPE.';base64,' .base64_encode($file)
            ));
            return $data;
        } else
        {
            
        }
        
    }

}
