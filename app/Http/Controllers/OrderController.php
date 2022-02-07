<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders=Orders::with(['userorders'])->paginate(2);  
    return $orders;
    
    }
    public function store(Request $request)
    {
        $request->validate([
            'completion'=>'required',
            'accepted'=>'required',
            'text'=>'required',
            'user_id'=>'required',
            'file_path'=>'required',
              ]);
        
              return  Orders::create($request->all());
    
    }


    public function destroy($order)
    {
        $orders=Orders::destroy($order);
    
        return response()->json($orders,204);
    
    }

    public function orderedit(Request $request, $order)

    {
      
        $orders= Orders::find($order);
            $orders->update($request->all());
            return  $orders;
    }
    public function order($order)
    {
        $orders=Orders::findOrFail($order);
        return $orders;
    }

}
