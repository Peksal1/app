<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
   
    public function index(Request $request)
    {
        $query = Messages::query();
    if (!empty($request->searchKeyword)) {
        $query->where('subject', 'LIKE', "%{$request->searchKeyword}%");
    }
    if (!empty($request->isRead)) {
        $query->where('isread', explode(',', $request->isRead));
    }
    
    return $query->paginate(8);
}
  
    public function isRead(Request $request, $message)
    {
        $messages=Messages::find($message) ->update(['isread' => 1]);;
 
    }

    public function show($specific_message)
    {
   
        $specific_message = Messages::where('id',$specific_message)->first();
        return response()->json($specific_message);
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
