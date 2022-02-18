<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Resources\ShopResource;

class ShopController extends Controller
{

    public function index(Request $request)
    {
        $shopQuery = Shop::query();
         if($request->searchKeyword != null){
            $shopQuery->where('work_name','LIKE',"%{$request->searchKeyword}%");
        }
         $shops = $shopQuery->paginate(4);
        return ShopResource::collection( $shops);
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
        $shops = Shop::destroy($shop);

        return response()->json($shops, 204);
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
}
