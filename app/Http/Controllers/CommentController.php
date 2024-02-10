<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function show(Comments $comment)
    {
        return response()->json($comment, 200);
    }

    public function create(CommentCreateRequest $request)
    {
        Comments::create($request->all());
        
        return back()->with('message', 'Successfully Added message!');
    }

    public function update(Request $request, Comments $comment)
    {
        $comment->update($request->all());

        return back()->with('message', 'Sucessfully Updated message!');
    }

    public function delete(Comments $comment)
    {
        $comment->delete();

        return back()->with('message', 'Successfully deleted message!');
        // if(Gate::allows('comment-delete', $comment)){
        // }else {
        //     return back()->with('error', 'Unauthorize');
        // }
    }
}
