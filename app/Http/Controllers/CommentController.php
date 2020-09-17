<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request,$post){
        
        $this->validate($request,[
            'comment' => 'required',
        ]);

        $comments = new Comment();
        $comments->post_id = $post;
        $comments->user_id = Auth::id();
        $comments->comment = $request->comment;
        $comments->save();

        Toastr::success('Comment Successfull','Success');
        return redirect()->back();
    }
}
