<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts= Post::paginate(5);
        return view('post',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $rules = [
            'title' => 'required:posts,title',
            'image' => 'required:posts,image',
            'content' => 'required:posts,content',
            ];
        $messages = [
            'title.required' => 'Enter the post title',
            'image.required' => 'Enter the post image',
            'content.required' => 'Enter the content',
            ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInputs($request->all());
        }
        $post = new Post();
        $post->title = $request->title;
        $post->image = $request->image;
        $post->content = $request->content;
        $post->user()->associate($request->user);
        $post->save();
        if ($post) {
            return response()->json([
                'id' => $post->id,
                'title' => $post->title,
                'image' => $post->image,
                'content' => $post->content,
                'user' => $post->user,
            ]);
        } else
        {
            return response()->json([
                'message'=> 'post not created'
            ],404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        if(!empty($post))
        {
            return response()->json($post);
        }
        else
        {
            return response()->json([
                'message'=> 'post not found'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post = Post::find($post->id);
        if (!$post) {
            return redirect()->back();
        }

        $post->title = $request->title;
        $post->image = $request->image;
        $post->content = $request->content;
        $post->user()->associate($request->user);
        $post->save();

        if ($post) {
            return response()->json([
                'id' => $post->id,
                'title' => $post->title,
                'image' => $post->image,
                'content' => $post->content,
                'user' => $post->user,
            ]);
        }
        else
        {
            return response()->json([
                'message'=> 'post not updated'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post_id)
    {
        $post = Post::find($post_id);
        if (!$post) {
            return redirect()->back();
        }
        $post->delete();
        if ($post) {
            return response()->json([
                'id' => $post_id,
            ]);
        } else
        {
            return response()->json([
                'message'=> 'post not deleted'
            ],404);
        }
    }
}
