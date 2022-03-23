<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchases;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function user_purchases(Request $request){
        
        $purchases = auth()->user()->purchases()->with('store')->paginate(5);
        return $purchases;  
  
    }
    public function index(Request $request)
    {
        $query= Purchases::query()->with('store')->with('user');
    if (!empty($request->searchKeyword)) {
        $query->where('uuid', 'LIKE', "%{$request->searchKeyword}%");
    }
    return $query->paginate(8);
}
    // public function show($portfolio)
    // {
   
    //     $portfolio = Portfolio::where('id',$portfolio)->first();
    //     return response()->json($portfolio);
    // }
   
    public function show($specific_purchase)
    {
   
        $specific_purchase = Purchases::where('id',$specific_purchase)->with('store')->with('user')->first();
        return response()->json($specific_purchase);
    }

}
