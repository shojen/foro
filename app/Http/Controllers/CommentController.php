<?php

namespace App\Http\Controllers;

use App\{Post,Comment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request,Post $post)
    {        
    	$v=Validator::make($request->all(),[
    			'comment' => 'required|max:1000'
    		]);
    	if($v->fails())
    	{
    		return back()->withErrors($v)->withInput();
    	}
    	auth()->user()->comment($post,$request->get('comment'));

    	return redirect($post->url);
    }

    public function accept(Comment $comment)
    {   
        $this->authorize('accept',$comment);
        $comment->MarkAsAnswer();
        return redirect($comment->post->url);
    }
}
