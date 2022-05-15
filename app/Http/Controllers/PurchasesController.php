<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchases;
use App\Models\Digital_purchase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function user_purchases(Request $request){
        
        $purchases = auth()->user()->purchases()->where('is_paid', 1)->with('store')->paginate(4);
        return $purchases;  
  
    }
    public function userDigitalPurchases(Request $request) {

        $digitalpurchases = auth()->user()->digitalPurchases()->where('is_paid', 1)->with('painting')->paginate(4);
        return $digitalpurchases;
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
    public function showDigital($specific_purchase)
    {
   
        $specific_purchase = auth()->user()->digitalPurchases()->where('id',$specific_purchase)->with('painting')->first();
        return response()->json($specific_purchase);
    }
}
