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
        $query= Purchases::query()->where('is_paid',1)->with('store')->with('user')->with('shipping');
        if (!empty($request->trackingFilter)) {    
            $query->where('tracking_number', $request->trackingFilter);
        }
    if (!empty($request->searchKeyword)) {
        $query->where('uuid', 'LIKE', "%{$request->searchKeyword}%");
    }
    
    return $query->paginate(4);
}
    // public function show($portfolio)
    // {
   
    //     $portfolio = Portfolio::where('id',$portfolio)->first();
    //     return response()->json($portfolio);
    // }
    public function update($purchase, Request $request)
    {
     
      $purchase = Purchases::find($purchase);
     $purchaseData =   $request->all();

  
          if (  $purchase->update($purchaseData)) {
              return response()->json([
                  'success' => true,
                  'message' => 'The tracking info has been updated successfully',
                  'purchase' => $purchase
              ], 200);
          } else {
              return response()->json(['success' => false, 'message' => 'Tracking not updated'], 400);
          }
  
  
  }
    public function show($specific_purchase)
    {
   
        $specific_purchase = Purchases::where('id',$specific_purchase)->with('store')->with('user')->with('shipping')->first();
        return response()->json($specific_purchase);
    }
    public function showDigital($specific_purchase)
    {
   
        $specific_purchase = auth()->user()->digitalPurchases()->where('id',$specific_purchase)->with('painting')->first();
        return response()->json($specific_purchase);
    }

    public function downloadDigital($id){
        // if(!auth()->user()) 
        //     return abort(401);

        // $purchase = Purchases::where('id',$id)->first();

        // if(auth()->user()->id != $purchase->user_id)
        //     return abort(401);
        

        return 'you can download the file';
     }
}
