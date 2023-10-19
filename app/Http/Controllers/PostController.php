<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Post;
use App\Traits\Attachment;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use Attachment;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //edit its posts just
        $posts = Post::where('user_id',Auth::user()->id);
        $posts = $posts->paginate(5);
        return view('post',['posts'=>$posts]);
    }

   public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title; 
        if ($request->hasfile('image')) {
            $post->image = $this->saveFile(
                $request->file('image'),
                'attachment'
            );
        }
        $post->content = $request->content;
        $post->user()->associate($request->user);
        $post->save();
        if ($post) {
            return response()->json([
                'id' => $post->id,
                'title' => $post->title,
                'image' => $post->image,
                'content' => $post->content,
                'user' => $post->user->name,
            ]);
        } else
        {
            return response()->json([
                'message'=> 'post not created'
            ],404);
        }
    }

    public function update(Request $request, int $post_id)
    {
        Log::info("request", [$request->all()]);
        $post = Post::find($post_id);
        if (!$request) {
            return redirect()->back();
        }
        dd($request->all());
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
    public function destroy(int $id)
    {
       $post = Post::find($id);
        if (!$post) {
            return redirect()->back();
        }
       $post->delete();
        if ($post) {
            return response()->json([
                'id' => $id,
            ]);
        } else
        {
            return response()->json([
                'message'=> 'post not deleted'
            ],404);
        }
    }
}
