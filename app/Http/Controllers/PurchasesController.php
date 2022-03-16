<?php

namespace App\Http\Controllers;

use App\Models\purchases;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function users_purchases($id){
        $purchase = Purchases::where('user_id', $id)->firstOrFail();
    
    
         
    
            return response()->json($purchase, 200, [], JSON_PRETTY_PRINT);
    } 
}
