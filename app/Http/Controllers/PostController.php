<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::with('comments')->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function ownPost()
    {
        $posts = auth()->user()->posts()->latest()->paginate(10);
        
        return view('posts.own', compact('posts'));
    }

    public function add()
    {
        return view('posts.add');
    }

    public function store(PostCreateRequest $request)
    {
        Posts::create($request->all());

        return redirect(route('index'));
    }

    public function detail(Posts $post)
    {
        $comments = $post->comments;

        return view('posts.detail', compact('post', 'comments'));
    }

    public function edit(Posts $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Posts $post, PostUpdateRequest $request)
    {
        $post->update($request->all());
        
        return redirect(route('post.own'));
    }

    public function delete(Posts $post)
    {
        $post->delete();

        return back()->with('message', 'Successfully Deleted.');
    }
}
