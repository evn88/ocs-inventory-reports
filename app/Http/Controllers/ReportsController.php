<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Hardwares;
use App\Drives;

class ReportsController extends Controller
{
    public function allComputers()
    {
        $objects = Hardwares::with('storages','drives','accountinfo','monitors')->get();
        
        //dd($objects->first());
        //dd(\App\Temp_files::with('hardwares')->get());
        return view('reports.allComputers', ['objects'=> $objects]);

    }
    
    public function allPrinters()
    {
        $objects = Hardwares::with('printers','accountinfo')->get();

        return view('reports.allPrinters', ['objects'=> $objects]);

    }
    
    public function allLicenses()
    {
        $objects = Hardwares::with('accountinfo','temp_files')->get();
        $ids = DB::table('temp_files')->pluck('ID')->toJson();
        return view('reports.allLicenses', ['objects'=> $objects, 'ids'=> $ids]);
    }

    public function allMonitors()
    {
        $objects = Hardwares::with('storages','drives','accountinfo','monitors')->get();
        
        return view('reports.allMonitors', ['objects'=> $objects]);
    }

     public function hddCapacity()
    {
        $objects = DB::select('call HDD_capacity_by_filials');
        
        return view('reports.hddCapacity', ['objects'=> $objects]);
    }
    
    public function test()
    {
        $objects = DB::select('call HDD_capacity_by_filials');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

 
        
        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();

        

        // Adding Text element to the Section having font styled by default...
        $section->addText(
            htmlspecialchars(
                'Объем данных хранящихся на HDD по филиалам'                    
            )
        );

        foreach ($objects as $obj){
        $section->addText(
                $obj->TAG.',      Занято: '.round($obj->Occupate_space_Gb,0).' Гб'
            );
        }
            
        // Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('result/helloWorld.docx');


        echo date('H:i:s'), ' Creating new TemplateProcessor instance...';
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('result/Sample_07_TemplateCloneRow.docx');
        // Variables on different parts of document
        $templateProcessor->setValue('weekday', date('l'));            // On section/content
        $templateProcessor->setValue('time', date('d.m.Y H:i'));             // On footer
        $templateProcessor->setValue('serverName', realpath(__DIR__)); // On header
        // Simple table

        $templateProcessor->cloneRow('rowValue', count($objects));
        $templateProcessor->setValue('myReplacedValue', count($objects));

        $i = 1;
        foreach ($objects as $obj){
        
            $templateProcessor->setValue('rowValue#'.$i, $obj->TAG);
            $templateProcessor->setValue('rowNumber#'.$i, round($obj->Occupate_space_Gb,0));
            $i++;
        }

        // Table with a spanned cell
        $templateProcessor->cloneRow('userId', 3);
        $templateProcessor->setValue('userId#1', '1');
        $templateProcessor->setValue('userFirstName#1', 'James');
        $templateProcessor->setValue('userName#1', 'Taylor');
        $templateProcessor->setValue('userPhone#1', '+1 428 889 773');
        $templateProcessor->setValue('userId#2', '2');
        $templateProcessor->setValue('userFirstName#2', 'Robert');
        $templateProcessor->setValue('userName#2', 'Bell');
        $templateProcessor->setValue('userPhone#2', '+1 428 889 774');
        $templateProcessor->setValue('userId#3', '3');
        $templateProcessor->setValue('userFirstName#3', 'Michael');
        $templateProcessor->setValue('userName#3', 'Ray');
        $templateProcessor->setValue('userPhone#3', '+1 428 889 775');
        echo date('H:i:s'), ' Saving the result document...';
        $templateProcessor->saveAs('result/TemplateCloneRow.docx');


    }
}
