<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

class HeatMapController extends Controller
{
    public function index()
    {
        return view('pages.heatmap');
    }

    public function return_json()
    {
        $nyc_json = Storage::disk('local')->get('public\nyc.json');
        $nyc_json = json_decode($nyc_json, true);
        return $nyc_json;
    }

    public function return_image()
    {
        return Storage::disk('local')->get('public\legend.png');
    }

        
}
