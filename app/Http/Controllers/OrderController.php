<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Orders::with(['userorders'])->paginate(20);
        return $orders;
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
    public function order($order)
    {
        $orders = Orders::findOrFail($order);
        return $orders;
    }
}
