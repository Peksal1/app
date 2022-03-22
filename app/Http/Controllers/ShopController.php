<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use App\Models\Shop;
use App\Models\Shipping;
use App\Models\Painting_category;
use App\Models\Size;
use App\Models\Canvas;
use App\Models\Paint;
use Illuminate\Http\Request;

use App\Http\Resources\ShopResource;

class ShopController extends Controller
{

    public function index(Request $request)
    {
        $query= Shop::query();
    if (!empty($request->cat)) {
        $query->whereIn('category_id', explode(',', $request->cat));
    }
    if (!empty($request->sizefilter)) {
        $query->whereIn('size_id', explode(',', $request->sizefilter));
    }
    if (!empty($request->canvasfilter)) {
        $query->whereIn('canvas_id', explode(',', $request->canvasfilter));
    }
    if (!empty($request->paintfilter)) {    
        $query->whereIn('paint_id', explode(',', $request->paintfilter));
    }
    if (!empty($request->searchKeyword)) {
        $query->where('work_name', 'LIKE', "%{$request->searchKeyword}%");
    }
    return $query->paginate(4);
}
    
    public function store(Request $request)
    {
        $shopData =   $request->all();
        // check if request has image

        if ($request->hasFile('file_path')) {
            // get image from request
            $image = $request->file('file_path');
            // get image name
            $imageName = $image->getClientOriginalName();
            // move image to public/images
            $image->move(public_path('sale'), $imageName);
            // save image name to database
            $shopData['file_path'] = $imageName;
        }

        $shop = Shop::create($shopData);


        if ($shop) {
            return response()->json([
                'success' => true,
                'message' => 'Shop item has been created successfully',
                'shop' => $shop
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Shop item not created'], 400);
        }
    }


    public function destroy($shop)
    {
      $shops=Shop::destroy($shop);
  
      return response()->json($shops,204);
  
  }

   
    public function shopedit(Request $request, $shop)

    {

        $shops = Shop::find($shop);
        $shops->update($request->all());
        return  $shops;
    }
    public function shop($shop)
    {
        $shops = Shop::findOrFail($shop);
        return $shops;
    }
    public function create_shipping(Request $request)
    {
         $shipping = Shipping::create($request->all());
        return response()->json(['success' => true, 'message' => 'Shipping added'],200);
        
    }

    public function checkPurchase($pruchaseId){
    
       $order = Purchases::where('uuid', $pruchaseId)->first();
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
