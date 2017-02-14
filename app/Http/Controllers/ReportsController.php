<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hardwares;

class ReportsController extends Controller
{
    public function allComputers()
    {
        $objects = Hardwares::with('storages','monitors','accountinfo')->get();
       
        //dd($objects->accountinfo);
        return view('reports.allComputers', ['objects'=> $objects]);
        //return view('reports.default', compact($objects));
    }
    
    public function allPrinters()
    {
        $objects = Hardwares::with('printers','accountinfo')->get();
       
        //dd($objects->accountinfo);
        return view('reports.allPrinters', ['objects'=> $objects]);
        //return view('reports.default', compact($objects));
    }
}
