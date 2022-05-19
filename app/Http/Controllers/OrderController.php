<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order_message;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderMessageResource;


class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orderQuery = Orders::where('is_paid', '1')->with('size', 'canvas', 'paint');
         if($request->searchKeyword != null){
            $orderQuery->where('text','LIKE',"%{$request->searchKeyword}%");
        }
         $orders = $orderQuery->paginate(4);
         return response()->json($orders);
       // return OrderResource::collection( $orders);
    }
    public function completedOrders(Request $request)
    {
        $orderQuery = Orders::where('is_paid', '1')->where('completion', '1');
         if($request->searchKeyword != null){
            $orderQuery->where('text','LIKE',"%{$request->searchKeyword}%");
        }
         $orders = $orderQuery->paginate(4);
         return response()->json($orders);
       // return OrderResource::collection( $orders);
    }
    public function store(Request $request)
    {
        $orderData =   $request->all();
        // check if request has image

        if ($request->hasFile('image')) {
            // get image from request
            $image = $request->file('image');
            // get image name
            $imageName = $image->getClientOriginalName();
            // move image to public/images
            $image->move(public_path('images'), $imageName);
            // save image name to database
            $orderData['file_path'] = $imageName;
        }

        $order = Orders::create($orderData);


        if ($order) {
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'order' => $order
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Order not created'], 400);
        }
    }


    public function destroy($order)
    {
        $orders = Orders::destroy($order);

        return response()->json($orders, 204);
    }

    public function orderedit(Request $request, $order)

    {

        $orders = Orders::find($order);
        $orders->update($request->all());
        return  $orders;
    }
    public function update($order, Request $request)
  {
   
    $order = Orders::find($order);
   $orderData =   $request->all();

        if ($request->hasFile('file_path')) {
            // get image from request
            $image = $request->file('file_path');
            // get image name
            $imageName = $image->getClientOriginalName();
            // move image to public/images
            $image->move(public_path('images'), $imageName);
            // save image name to database
            $orderData['file_path'] = $imageName;

        
        }else{
             $orderData['file_path'] = $order->file_path;
        }


        if (  $order->update($orderData)) {
            return response()->json([
                'success' => true,
                'message' => 'Order item has been updated successfully',
                'order' => $order
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Order item not updated'], 400);
        }


}
    public function order($order)
    {
        $orders = Orders::findOrFail($order);
        return $orders;
    }
    public function showOrder($specificOrder)
    {
   
        $specificOrder = auth()->user()->user_orders()->where('id',$specificOrder)->first();
        return response()->json($specificOrder);
    }
    public function showAdminOrder($specificOrder)
    {
   
        $specificOrder = Orders::where('id',$specificOrder)->with('user', 'shipping', 'paint', 'canvas', 'size')->first();
        return response()->json($specificOrder);
    }
    public function show(Request $request){
        
        $orders = auth()->user()->user_orders()->where('is_paid', '0')->with('size', 'paint', 'canvas')->paginate(5);
        return $orders;  
  
    }
    public function show_paid(Request $request){
        
        $orders = auth()->user()->user_orders()->where('is_paid', '1')->with('size', 'paint', 'canvas')->paginate(5);
        return $orders;  
  
    }
 
    public function get_order_messages($order_messages)
    {
    // $order = Order::where('user_id',auth()->user()->id)->where('id',$order_message)->first();
   
    // if admin

        $order_messages = Order_message::where('order_id', $order_messages)->with('user')->get();
        return $order_messages;
   
    
    // if not admin
    
        // $order_messages = Order_message::where('order_id', $order_messages)->with('user')->get();
        // return $order_messages;
    }
    
    public function adminGetMessages($order_messages)

    {
         $order_messages = Order_message::where('order_id', $order_messages)->with('user')->get();
         return $order_messages;
    }
 
    public function post_order_messages(Request $request)
    {
       
        $order_message = new Order_message;
        $order_message->message = $request->message;
        $order_message->user_id = auth()->user()->id;
        $order_message->order_id = $request->order_id;
        $order_message->save();
           $res['order_message'] = $order_message;
           $res['status'] = 'success';

        return response()->json($res);
      
    }
    public function delete_order_messages($order_message)
    {
    try{
        $order_message = Order_message::find($order_message);
        $order_message->delete();
        $res['status'] = 'success';
     }catch(Exception $e){
        $res['status'] = 'error';
     }
     return response()->json($res);
 }

 public function checkOrderPurchase($pruchaseId){
    
    $order = Orders::where('uuid', $pruchaseId)->first();
     $shippingInfo = Shipping::where('purchase_id', $order->uuid)->first();
    if( $order){
         $res['success'] = true;
         $res['order'] = $order;
         $res['isShippingInfoFilled'] = !!$shippingInfo;
         return response()->json($res, 200);
     }else{
         $res['success'] = false;
         $res['message'] = 'Order not found';
         return response()->json($res, 200);
     }
 }
}
