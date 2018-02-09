<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Hardwares;
use App\Drives;
use App\Accountinfo;
use App\Apc;
use Illuminate\Support\Facades\Storage;

class ExportsController extends Controller
{
    public function index()
    {
        return view('exports.index');
    }

    public function rac()
    {
        $disk = Storage::disk('exports');
        $filials = Accountinfo::filials(); //массив филиалов
        $objects = Hardwares::with('storages','drives','accountinfo','monitors', 'bios','softwares')->get();
        $raw = $objects->where('accountinfo.fields_4', 'Волгоград');

        $date_gen = date('H:i:s');
   
            foreach($filials as $f){ //цикл филиалы
                $comps = $objects->where('accountinfo.fields_4', $f); //получаем значения по каждому компу
                $disk->makeDirectory('/out/'.$f); //создаем директории для выгрузки
                
                foreach($comps as $comp){ //цикл компьютеры                   
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/exports').'/templates/rac.docx');

                    // Variables on different parts of document
                    $templateProcessor->setValue('weekday', date('l'));            // On section/content
                    $templateProcessor->setValue('time', date('d.m.Y H:i'));             // On footer
                    $templateProcessor->setValue('serverName', realpath(__DIR__)); // On header


                    //Header
                    $templateProcessor->setValue('computerName', $comp->NAME);
                    $templateProcessor->setValue('fio', $comp['accountinfo']->fields_5);
                    
                    //filial
                    $templateProcessor->setValue('filial', $f);

                    //uchastok
                    $uchastok = ($comp['accountinfo']->TAG) ? $comp['accountinfo']->TAG : "-//-";
                    $templateProcessor->setValue('uchastok', $uchastok);

                    //profession
                    $prof = ($comp['accountinfo']->fields_6) ? $comp['accountinfo']->fields_6 : "-//-";
                    $templateProcessor->setValue('profession', $prof);

                    //Мониторы
                    $i=0;
                    foreach($comp['monitors'] as $monitor){
                       $monitorManufacturer[$i] = $monitor->MANUFACTURER;
                       $monitorModel[$i] = $monitor->CAPTION;
                       $monitorSerial[$i] = ($monitor->SERIAL) ? $monitor->SERIAL : "-//-";
                       $i++;
                    }
                   
                    $templateProcessor->setValue('monitorManufacturer', implode(";\r\n",$monitorManufacturer).";");
                    $templateProcessor->setValue('monitorModel',   implode(";\r\n",$monitorModel).";");
                    $templateProcessor->setValue('monitorSerialNum',   implode(";\r\n",$monitorSerial).";");

                    for($i=0; $i<= count($comp['monitors']); $i++){
                        unset($monitorManufacturer[$i]);
                        unset($monitorModel[$i]);
                        unset($monitorSerial[$i]);
                    }
                   
                    //Системник
                    $templateProcessor->setValue('computerManufacturer', $comp['bios']['SMANUFACTURER']);
                    $templateProcessor->setValue('computerModel', $comp['bios']['SMODEL']);
                    $templateProcessor->setValue('computerSerialNum', $comp['bios']['SSN']);

                    //APC
                    $apcManufacturer = explode(" ",$comp['accountinfo']['apc']['TVALUE']); //возможно будут проблемы с отображением правильных значений
                    // нужно добавить ->where('config.NAME','like','ACCOUNT_VALUE_IBP_%')

                    $templateProcessor->setValue('apcModel', $comp['accountinfo']['apc']['TVALUE']);
                    $templateProcessor->setValue('apcManufacturer', $apcManufacturer[0]);

                    //OS
                    $templateProcessor->setValue('osName', $comp->OSNAME);
                    $templateProcessor->setValue('osVersion', $comp->OSVERSION);
                    $templateProcessor->setValue('osVersion', $comp->WINPRODID);

                    //SOFT
                    $a = 1;
                    foreach($comp['softwares'] as $soft){
                        if(stristr($soft['NAME'], 'Update') === FALSE){
                            $a++;
                        }
                    }
                    $templateProcessor->cloneRow('softName', $a);
                    $i=0;
                    foreach($comp['softwares'] as $soft){
                        if(stristr($soft['NAME'], 'Update') === FALSE){
                            $templateProcessor->setValue('sNum#'.$i, $i);
                            $templateProcessor->setValue('softName#'.$i, (string)$soft['NAME']);
                            $templateProcessor->setValue('softVersion#'.$i, (string)$soft['VERSION']);
                            $templateProcessor->setValue('softEditor#'.$i, (string)$soft['PUBLISHER']);
                            $i++;
                        }
                    }
                    //$templateProcessor->setValue('myReplacedValue', count($objects));


                    $templateProcessor->saveAs(storage_path('app/exports').'/out/'.$f.'/'.$comp->NAME.'.docx');
                }
                
            }

        /*
        $i = 1;
        foreach ($objects as $obj){
            $templateProcessor->setValue('softName#'.$i, $obj->TAG);
            $templateProcessor->setValue('sNum#'.$i, round($obj->Occupate_space_Gb,0));
            $i++;
        }*/
        
        

        return view('exports.rac', ['objects'=> $objects,'date'=>$date_gen]);
    }

}