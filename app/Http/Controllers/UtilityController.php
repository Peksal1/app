<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class UtilityController extends Controller
{
     public function sizes(){
     
        $sizes = Size::all();
        $res['sizes'] = $sizes;
          
        return response()->json($res);
     
     }


     public function store_size(Request $request){
       
         $size = new Size;
         $size->type = $request->type;
         $size->price_in_eur = $request->price_in_eur;
         $size->save();
            $res['size'] = $size;
            $res['status'] = 'success';

         return response()->json($res);
       
     }

     public function delete_size($size){
         try{
            $size = Size::find($size);
            $size->delete();
            $res['status'] = 'success';
         }catch(Exception $e){
            $res['status'] = 'error';
         }
         return response()->json($res);
     }
}
