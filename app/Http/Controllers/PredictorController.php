<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Phpml\Classification\KNearestNeighbors;

class PredictorController extends Controller
{
    public function index()
    {
        return view('pages.predictor');
    }

    public function airbnb_url(Request $request) {


        $request -> validate([
            'url' => 'required|string',
        ]);

        $host = 'http://localhost:4444';
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities);
        $driver->get($request->url);
        $driver->manage()->window()->maximize();
        $name = $driver->findElement(WebDriverBy::xpath('//*[@id="site-content"]/div/div[1]/div/div/div/section/div[1]/div[1]/h1'));
        $room_type = $driver->findElement(WebDriverBy::xpath('//*[@id="site-content" ]/div/div[4]/div/div/div[1]/div[2]/div/div/div/section/div/div/div[2]/div[1]'));
        $location = $driver->findElement(WebDriverBy::xpath('//*[@id="site-content"]/div/div[1]/div/div/div/section/div[1]/div[2]/span/span/a'));
        $price = $driver->findElement(WebDriverBy::xpath('//*[@id="site-content"]/div/div[4]/div/div/div[3]/div/div/div[1]/div/div/div/div/div[1]/div/div/span/span[1]'));
        
        $response = array();
        $response["name"] = $name->getText();
        $response["room_type"] = $room_type->getText();
        $response["location"] = $location->getText();
        $response["price"] = $price->getText();

        return response()->json($response, 200);

    }

    public function pred_model(Request $request)
    {
        //$request -> validate([
        //    'name' => 'required|string',
        //    'location' => 'required|string',
        //    'room_type' => 'required|string',
        //    'price' => 'required|string'
        //]);

        return response()->json($request, 200);
    }

}
