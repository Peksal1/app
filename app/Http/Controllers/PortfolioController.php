<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio;
use App\Models\Collection;
use App\Http\Resources\PortfolioResource;

use Image;
use Auth;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    $portfolios=Portfolio::with(['portfolio_collection'])->paginate(20);

    return $portfolios;
    }

    public function full_portfolio(Request $request)
    {
        $portfolioQuery = Portfolio::query();
         if($request->searchKeyword != null){
            $portfolioQuery->where('work_name','LIKE',"%{$request->searchKeyword}%");
        }
         $portfolios = $portfolioQuery->paginate(4);
        return PortfolioResource::collection( $portfolios);
    }

    public function collections()
    {
        $collections=Collection::paginate(20);
    return $collections;
    }

    public function show($portfolio)
    {
   
        $portfolio = Portfolio::where('id',$portfolio)->with('digital_paintings')->first();
        return response()->json($portfolio);
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
    public function destroy($portfolio)
    {
        $portfolios=Portfolio::destroy($portfolio);
    
        return response()->json($portfolios,204);
    
    }

    public function update(Request $request, $portfolio)
    {
          
        $portfolios= Portfolio::find($portfolio);
            $portfolios->update($request->all());
            return  $portfolios;
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
}
