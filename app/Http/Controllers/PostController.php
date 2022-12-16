<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function viewSinglePost(Post $post) { // function in /resources/routes/web.php
        return view('single-post', ['post'=>$post]); // blade file in /view/components/
    }

    public function showCreateForm() {
        return view('create-post'); // blade file
    }

    public function storeNewPost(Request $request) {
        $incomingFields = $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);
        // strip of potential malicious HTML
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        // get userId from the current session
        $incomingFields['user_id'] = auth()->id();
        // write with the Post Model
        $newPost = Post::create($incomingFields);
        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created.');
    }
}
