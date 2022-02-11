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
             if($request->file('file')){

             /* Multiple file upload */
             $files = $request->file('file');
             if(!is_array($files)){
                 $files = [$files];
             }
             //loop through the array
             for($i=0; $i<count($files); $i++){
                 $file = $files[$i];
                 $filename = $file->getClientOriginalName();
                 $filename = str_replace(' ', '', $filename);
                 $file->storeAs('uploads', $filename);
             }
             return response()->json(['message'=>'file uploaded', 'data'=>$request->text], 200);
             }
             else{
                 return response()->json(['message'=>'error while uploading file'], 503);
             }
    
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
