<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function delete(Post $post) {
        if( auth()->user()->cannot('delete', $post) ) {
            return 'You cannot delete this post';
        }
        $post->delete();
        return redirect('/profile/'.auth()->user()->username)->with('success', 'Post succesfully deleted.' );       
    }
    public function viewSinglePost(Post $post) { // function in /resources/routes/web.php
        // strip certains tags in html
        $ourHTML = strip_tags(Str::markdown($post->body), 
            // what tags ARE allowed
            '<p><ul><li><strong><em><h3><br>');
        $post['body'] = $ourHTML;
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
