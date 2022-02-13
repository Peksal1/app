<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio;

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
        $portfolios=Portfolio::paginate(20);
    return $portfolios;
    }

    /*public function store(Request $request)
    {
        $request->validate([

            'work_name'=>'required',
    
            'file_path'=>'required',
    
            'description'=>'required',
    
            
    
              ]);


              return  Portfolio::create($request->all());
    } */
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
}
