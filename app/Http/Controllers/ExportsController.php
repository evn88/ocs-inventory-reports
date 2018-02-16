<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Hardwares;
use App\Drives;
use App\Accountinfo;
use App\Apc;
use App\Configs;
use Illuminate\Support\Facades\Storage;

class ExportsController extends Controller
{
    public function index()
    {
        return view('exports.index');
    }

    public function rac()
    {
        $date_gen = date('d.m.Y H:i');
        $disk = Storage::disk('exports');
        $filials = Accountinfo::filials(); //массив филиалов
        $objects = Hardwares::with('storages','drives','accountinfo','monitors', 'bios','softwares')->get();

            foreach($filials as &$f){ //цикл филиалы
                $comps = $objects->where('accountinfo.fields_4', $f)->where('accountinfo.fields_32','=','1'); //получаем значения по каждому компу
                $disk->makeDirectory('/out/'.$f); //создаем директории для выгрузки
                
                foreach($comps as $key => &$comp){ //цикл компьютеры                   
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/exports').'/templates/rac.docx');

                    // Variables on different parts of document
                    $templateProcessor->setValue('time', $date_gen);             // On footer

                    //Header
                    $templateProcessor->setValue('computerName', $comp->NAME);
                    $templateProcessor->setValue('fio', $comp['accountinfo']->fields_5);
                    
                    //filial
                    $templateProcessor->setValue('filial', $f);

                    //uchastok
                    $uchastok = ($comp['accountinfo']->TAG) ? $comp['accountinfo']->TAG : "-//-";
                    $templateProcessor->setValue('uchastok', $uchastok);

                    //address
                    $softCountddresses =json_decode($disk->get('/templates/addresses.json'));
                    $templateProcessor->setValue('address', @$softCountddresses->{$uchastok});

                    //profession
                    $prof = ($comp['accountinfo']->fields_6) ? $comp['accountinfo']->fields_6 : "-//-";
                    $templateProcessor->setValue('profession', $prof);

                    //Мониторы
                    $i=0;
                    foreach($comp['monitors'] as $monitor){
                       $monitorManufacturer[$i] = $i.": ".$monitor->MANUFACTURER;
                       $monitorModel[$i] = $i.": ".$monitor->CAPTION;
                       $monitorSerial[$i] = ($monitor->SERIAL) ? $i.": ".$monitor->SERIAL : "-//-";
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
                    $apc = Configs::apc($comp['accountinfo']->fields_30)->get();
   
                    $apcTvalue = (isset($apc[0])) ?  $apc[0]['TVALUE'] : "-//-";
                    $apcCountpcManufacturer = explode(" ", $apcTvalue); 
                    $templateProcessor->setValue('apcModel',  $apcTvalue);
                    $templateProcessor->setValue('apcManufacturer', $apcCountpcManufacturer[0]);
                    
                    $softCountArr[$key]['apc'] = $apcTvalue; //lдля вывода на экран
                    

                    //OS
                    $osEditor =  explode(" ", $comp->OSNAME);
                    $templateProcessor->setValue('osName', $comp->OSNAME);
                    $templateProcessor->setValue('osVersion', $comp->OSVERSION);
                    $templateProcessor->setValue('osEditor', $osEditor[0]);
                    $templateProcessor->setValue('osLicenseNum', $comp->WINPRODID);

                    //SOFT
                    $softCount = 0;
                    foreach($comp['softwares'] as $soft){
                        if(preg_match("/(Update|Hotfix|Redistributable|Additional|Runtime)\b/i", $soft['NAME'])===0){
                            $softCount++;
                        }
                    }
                    $templateProcessor->cloneRow('sNum', $softCount-1); //создаем необходимое кол-во строк в таблице

                    $i = 1;
                    foreach($comp['softwares'] as $soft){
                        if(preg_match("/(Update|Hotfix|Redistributable|Additional|Runtime)\b/i", $soft['NAME'])===0){
                            $templateProcessor->setValue('sNum#'.$i, $i+1);
                            $templateProcessor->setValue('softName#'.$i, htmlspecialchars($soft['NAME']));
                            $templateProcessor->setValue('softVersion#'.$i, htmlspecialchars($soft['VERSION']));
                            $templateProcessor->setValue('softEditor#'.$i, htmlspecialchars($soft['PUBLISHER']));
                            $i++;
                        }
                        if($i === $softCount ){ break; } //не выводим последнюю строку, там информация об ОС которая уже есть
                    }
                    
                    $softCountArr[$key]['name'] = $comp->NAME;
                    $softCountArr[$key]['count'] = $softCount;
                    $templateProcessor->saveAs(storage_path('app/exports/out/').$f.'/'.$comp->NAME.'.docx');
                }
                break;
            }       
        return view('exports.rac', ['objects'=> $objects,'date'=>$date_gen, 'softCount'=>$softCountArr]);
    }
}