<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Paint;
use App\Models\Canvas;
use App\Models\Painting_category;

class UtilityController extends Controller
{
    // SIZE

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

     // PAINT

     public function paints(){
     
        $paints = Paint::all();
        $res['paints'] = $paints;
          
        return response()->json($res);
     
     }


     public function store_paint(Request $request){
       
         $paint = new Paint;
         $paint->type = $request->type;
         $paint->price_in_eur = $request->price_in_eur;
         $paint->save();
            $res['paint'] = $paint;
            $res['status'] = 'success';

         return response()->json($res);
       
     }

     public function delete_paint($paint){
         try{
            $paint = Paint::find($paint);
            $paint->delete();
            $res['status'] = 'success';
         }catch(Exception $e){
            $res['status'] = 'error';
         }
         return response()->json($res);
     }

     // CANVAS

     public function canvases(){
     
        $canvases = Canvas::all();
        $res['canvases'] = $canvases;
          
        return response()->json($res);
     
     }


     public function store_canvas(Request $request){
       
         $canvas = new Canvas;
         $canvas->type = $request->type;
         $canvas->price_in_eur = $request->price_in_eur;
         $canvas->save();
            $res['canvas'] = $canvas;
            $res['status'] = 'success';

         return response()->json($res);
       
     }

     public function delete_canvas($canvas){
         try{
            $canvas = Canvas::find($canvas);
            $canvas->delete();
            $res['status'] = 'success';
         }catch(Exception $e){
            $res['status'] = 'error';
         }
         return response()->json($res);
     }

     public function all_paints()
     {
         $paints=Paint::paginate(20);
     return $paints;
     }
     public function all_canvases()
     {
         $canvases=Canvas::paginate(20);
     return $canvases;
     }
     public function all_sizes()
     {
         $sizes=Size::paginate(20);
     return $sizes;
     }

     public function painting_categories(){
     
      $painting_categories = Painting_category::all();
      $res['painting_categories'] = $painting_categories;
        
      return response()->json($res);
   
   }

   public function all_painting_categories()
   {
       $painting_categories=Painting_category::paginate(20);
   return $painting_categories;
   }
   public function store_painting_category(Request $request){
     
       $painting_category = new Painting_category;
       $painting_category->category = $request->category;
       $painting_category->save();
          $res['painting_category'] = $painting_category;
          $res['status'] = 'success';

       return response()->json($res);
     
   }

   public function delete_painting_category($painting_category){
       try{
          $painting_category = Painting_category::find($painting_category);
          $painting_category->delete();
          $res['status'] = 'success';
       }catch(Exception $e){
          $res['status'] = 'error';
       }
       return response()->json($res);
   }
}
