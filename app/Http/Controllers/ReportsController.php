<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hardwares;

class ReportsController extends Controller
{
    public function index()
    {
        $objects = Hardwares::with('storages','monitors','accountinfo')->get();
       
        //dd($objects->accountinfo);
        return view('reports.default', ['objects'=> $objects]);
        //return view('reports.default', compact($objects));
    }
}
