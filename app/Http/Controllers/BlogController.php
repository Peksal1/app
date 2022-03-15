<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BlogResource;
use App\Models\Blog_category;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    if(!empty($request->cat)){
    $data = Blog::where('blog_category_id',$request->cat)->paginate(4);
    return response()->json($data);
    }
    $blogQuery = Blog::query();
    $blogs = $blogQuery->paginate(4);
return BlogResource::collection( $blogs);
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
    public function show(Blog $blog)
    {
        $blogs=Blog::findOrFail($blog);
        return $blogs;
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
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
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
