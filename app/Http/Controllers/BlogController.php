<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BlogResource;
use App\Models\Blog_category;
use App\Models\Blog_comment;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Blog::query();
    if (!empty($request->cat)) {
        $query->whereIn('blog_category_id', explode(',', $request->cat));
    }
    if (!empty($request->searchKeyword)) {
        $query->where('title', 'LIKE', "%{$request->searchKeyword}%");
    }
    return $query->paginate(4);
}
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    

    public function new_category(Request $request){
       
        $blog_category = new Blog_category;
        $blog_category->category = $request->category;
        $blog_category->save();
           $res['blog_category'] = $blog_category;
           $res['status'] = 'success';

        return response()->json($res);
      
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBlogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $topicData =   $request->all();
        // check if request has image
        if ($request->hasFile('image')) {
            // get image from request
            
            $image = $request->file('image');
            // get image name
            $imageName = $image->getClientOriginalName();
            // move image to public/images
            $image->move(public_path('blog'), $imageName);
            // save image name to database
            $topicData['image'] = $imageName; 
        } 

        $topic = Blog::create($topicData);


        if ($topic) {
            return response()->json([
                'success' => true,
                'message' => 'Topic created successfully',
                'topic' => $topic
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Blog post was not created'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($blog)
    {
   
        $blog = Blog::where('id',$blog)->first();
        return response()->json($blog);
    }
    public function newComment(Request $request)
    {
       
        $blog_comment = new Blog_comment;
        $blog_comment->message = $request->message;
        $blog_comment->user_id = auth()->user()->id;
        $blog_comment->blog_id = $request->blog_id;
        $blog_comment->save();
           $res['blog_comment'] = $blog_comment;
           $res['status'] = 'success';

        return response()->json($res);
      
    }
    public function showComments($id)
    {
   
        $id = Blog_comment::where('blog_id',$id)->with('user')->get();
        return response()->json($id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogRequest  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function display( $id)

{
    $blog_comment = Blog_comment::with(['blog_comments'])->where('blog_id', $id)->latest()->get();
    return $blog_comment;
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($blog)
    {
        try{
           $blog = Blog::find($blog);
           $blog->delete();
           $res['status'] = 'success';
        }catch(Exception $e){
           $res['status'] = 'error';
        }
        return response()->json($res);
    }
    public function blog_search(Request $request, $title)
{
    $result = Blog::where('title', 'LIKE', '%'. $title. '%')->get();
    if(count($result)){
     return Response()->json($result);
    }
    else
    {
    return response()->json(['Result' => 'No posts found'], 404);
  }
}
public function post_blog_categories(Request $request, $title)
{

}

public function delete_blog_categories(Request $request, $title)
{

}

public function blog_categories()
{
     
    $blog_categories = Blog_category::all();
    $res['blog_categories'] = $blog_categories;
      
    return response()->json($res);
 
 }
}
