<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio;
use App\Models\Collection;
use App\Http\Resources\PortfolioResource;
use App\Models\Digital_painting;
use App\Models\Digital_purchase;

use Image;
use Auth;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    $portfolios=Portfolio::query()->with(['portfolio_collection'])->paginate(20);
    if (!empty($request->searchKeyword)) {
        $portfolios->where('work_name', 'LIKE', "%{$request->searchKeyword}%");
    }
    return $portfolios;
    }

    public function full_portfolio(Request $request)
    {
        $query= Portfolio::query();
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
    

    public function collections()
    {
        $collections=Collection::paginate(4);
    return $collections;
    }
  
    public function collection($collection)
    {
        $collection=Collection::where('id',$collection)->first();
    return $collection;
    }

    public function show($portfolio)
    {
   
        $portfolio = Portfolio::where('id',$portfolio)->with('digital_paintings', 'portfolio_collection', 'portfolio_category', 'portfolio_size', 'portfolio_canvas', 'portfolio_paint')->first();
        return response()->json($portfolio);
    }
    
    public function specificCollection($collection)
    {
   
        $collection = Collection::where('id',$collection)->first();
        return response()->json($collection);
    }
    public function store(Request $request)
    {
        $orderData =   $request->all();
        // check if request has image

        if ($request->hasFile('file_path')) {
            // get image from request
            $image = $request->file('file_path');
            // get image name
            $imageName = $image->getClientOriginalName();
            // move image to public/images
            $image->move(public_path('portfolio'), $imageName);
            // save image name to database
            $orderData['file_path'] = $imageName;
        }

        $order = Portfolio::create($orderData);


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
    public function newDigital(Request $request)
    {
        $digitalData =   $request->all();
        // check if request has image

        if ($request->hasFile('image')) {
            // get image from request
            $image = $request->file('image');
            // get image name
            $imageName = $image->getClientOriginalName();
            // move image to public/images
            $image->move(public_path('digital'), $imageName);
            // save image name to database
            $digitalData['image'] = $imageName;
        }

        $digital = Digital_painting::create($digitalData);


        if ($digital) {
            return response()->json([
                'success' => true,
                'message' => 'Digital painting was added successfully',
                'digital' => $digital
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Digital painting was not added'], 400);
        }
    }
    public function destroy($portfolio)
    {
        $portfolios=Portfolio::destroy($portfolio);
    
        return response()->json($portfolios,204);
    
    }
    public function destroyCollection($collection)
    {
        $collections=Collection::destroy($collection);
    
        return response()->json($collections,204);
    
    }
    public function updateCollection($collection, Request $request)
    {
     
      $collection = Collection::find($collection);
     $collectionData =   $request->all();
  
          if ($request->hasFile('image')) {
              // get image from request
              $image = $request->file('image');
              // get image name
              $imageName = $image->getClientOriginalName();
              // move image to public/images
              $image->move(public_path('collection'), $imageName);
              // save image name to database
              $collectionData['image'] = $imageName;
  
          
          }else{
               $collectionData['image'] = $collection->image;
          }
  
  
          if (  $collection->update($collectionData)) {
              return response()->json([
                  'success' => true,
                  'message' => 'The collection item has been updated successfully',
                  'collection' => $collection
              ], 200);
          } else {
              return response()->json(['success' => false, 'message' => 'The collection item was not updated'], 400);
          }
  
  
  }
    public function update($portfolio, Request $request)
    {
     
      $portfolio = Portfolio::find($portfolio);
     $portfolioData =   $request->all();
  
          if ($request->hasFile('file_path')) {
              // get image from request
              $image = $request->file('file_path');
              // get image name
              $imageName = $image->getClientOriginalName();
              // move image to public/images
              $image->move(public_path('portfolio'), $imageName);
              // save image name to database
              $portfolioData['file_path'] = $imageName;
  
          
          }else{
               $portfolioData['file_path'] = $portfolio->file_path;
          }
  
  
          if (  $portfolio->update($portfolioData)) {
              return response()->json([
                  'success' => true,
                  'message' => 'Portfolio item has been updated successfully',
                  'portfolio' => $portfolio
              ], 200);
          } else {
              return response()->json(['success' => false, 'message' => 'portfolio item not updated'], 400);
          }
  
  
  }
    public function portfolio_search(Request $request, $work_name)
    {
        $result = Portfolio::where('work_name', 'LIKE', '%'. $work_name. '%')->get();
        if(count($result)){
         return Response()->json($result);
        }
        else
        {
        return response()->json(['Result' => 'No works found'], 404);
      }
    }
    public function portfolio($portfolio)
    {
        $portfolios=Portfolio::findOrFail($portfolio);
        return $portfolios;
    }
    public function new_collection(Request $request)
    {
        $collectionData =   $request->all();
        // check if request has image

        if ($request->hasFile('image')) {
            // get image from request
            $image = $request->file('image');
            // get image name
            $imageName = $image->getClientOriginalName();
            // move image to public/images
            $image->move(public_path('collection'), $imageName);
            // save image name to database
            $collectionData['image'] = $imageName;
        }

        $collection = Collection::create($collectionData);


        if ($collection) {
            return response()->json([
                'success' => true,
                'message' => 'Collection created successfully',
                'collection' => $collection
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'The collection was not created not created'], 400);
        }
    }
    public function display( $id)

{
    $portfolio = Portfolio::with(['portfolio_collection'])->where('collection_id', $id)->latest()->get();
    return $portfolio;
}
public function checkDigitalPurchase($digital){
    
    $digital = Digital_purchase::where('uuid', $digital)->first();
    if( $digital){
         $res['success'] = true;
         $res['digital'] = $digital;
         return response()->json($res, 200);
     }else{
         $res['success'] = false;
         $res['message'] = 'Digital purchase not found';
         return response()->json($res, 200);
     }
 }
}
