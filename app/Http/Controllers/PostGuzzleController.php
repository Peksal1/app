<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use \CoinMarketCapApi;
use Illuminate\Support\Facades\Http;
use App\Models\Coin;
 
class PostGuzzleController extends Controller
{
    public function index()
    {
        $coins=CoinMarketCapApi::all_cryptos();
        return $coins;
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://pro-api.coinmarketcap.com/v1/',
            'headers' => [
                'X-CMC_PRO_API_KEY' => '71315173-bc6c-4d96-b195-bddd9d40075d',
                'Accepts' => 'application/json'
            ],
        ]);
        $response = $client->get('cryptocurrency/listings/latest');
        $contents = json_decode($response->getBody()->getContents(), true);
        print_r($contents); 
    }
    public function storeCoin(Request $request){
       
        $coin = new Coin;
        $coin->name = $request->type;
        $coin->symbol = $request->symbol;
        $coin->usd_price = $request->usd_price;
        $coin->total_supply = $request->total_supply;
        $coin->max_supply = $request->max_supply;
        $coin->date_added = $request->date_added;
        $coin->save();
           $res['coin'] = $coin;
           $res['status'] = 'success';

        return response()->json($res);
    }

   // public function store()
  //  {
  //      $response = Http::post('http://jsonplaceholder.typicode.com/posts', [
  //                  'title' => 'This is test from tutsmake.com',
  //                  'body' => 'This is test from tutsmake.com as body',
  //              ]);
   
  //      dd($response->successful());
  //  }
}