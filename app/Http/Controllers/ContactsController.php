<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
   
    public function index()
    {
        $messages=Messages::paginate(2);
        return $messages;
    }
    public function isRead(Request $request, $message)
    {
        $messages=Messages::find($message) ->update(['isread' => 1]);;
 
    }
    public function store(Request $request)
    {
        $request->validate([
    
            'name'=>'required',
    
            'Email'=>'required',
    
            'message'=>'required',

            'phone_number'=>'required',

            'subject'=>'required',
    
            
    
              ]);
    
        
    
              return  Messages::create($request->all());
    }
    public function destroy($message)
  {
    $messages=Messages::destroy($message);

    return response()->json($messages,204);

}
}
