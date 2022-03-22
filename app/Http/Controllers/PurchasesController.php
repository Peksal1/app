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
    // public function show($portfolio)
    // {
   
    //     $portfolio = Portfolio::where('id',$portfolio)->first();
    //     return response()->json($portfolio);
    // }
    public function show($purchase){
        
        $purchase = auth()->user()->purchases()->with('store')->where('id',$purchase)->first();
        return $purchase;  
  
    }

}
