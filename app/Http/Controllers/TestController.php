<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;



class TestController extends Controller
{
    public function index()
    {
        $host = 'http://localhost:4444';
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities);
        $driver->get('https://www.airbnb.com/rooms/42076319');
        $driver->manage()->window()->maximize();
        sleep(5);
        $room_type = $driver->findElement(WebDriverBy::xpath('//*[@id="site-content"]/div/div[4]/div/div/div[1]/div[2]/div/div/div/section/div/div/div[2]/div[1]'));
        $location = $driver->findElement(WebDriverBy::xpath('//*[@id="site-content"]/div/div[1]/div/div/div/section/div[1]/div[2]/span/span/a'));
        $price = $driver->findElement(WebDriverBy::xpath('//*[@id="site-content"]/div/div[4]/div/div/div[3]/div/div/div[1]/div/div/div/div/div[1]/div/div/span/span[1]'));
        $response = array();
        $response["room_type"] = $room_type->getText();
        $response["location"] = $location->getText();
        $response["price"] = $price->getText();

        print_r($response);

    }
}
