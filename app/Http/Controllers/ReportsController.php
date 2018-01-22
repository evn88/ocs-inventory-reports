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
        $objects = Hardwares::with('accountinfo','temp_files')->get();
        //dd(DB::table('temp_files')->pluck('ID')->toJson());        
        $ids = DB::table('temp_files')->pluck('ID')->toJson();
        return view('reports.allLicenses_test', ['objects'=> $objects, 'ids'=> $ids]);
    }
}
