<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use \CoinMarketCapApi;
use Illuminate\Http\Request;
use App\Models\Coin;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $coins=CoinMarketCapApi::all_cryptos();
        return $coins;
}
    
}
