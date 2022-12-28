<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendNewPostEmail;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function search($term) {
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
    public function actuallyUpdate(Post $post, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $post->update($incomingFields);
        // 'back()' = return to the previous page
        return back()->with('success', 'Post succesfully updated.');
    }

    public function showEditForm(Post $post) {
        return view('edit-post', ['post'=> $post]);
    }

    public function delete(Post $post) {
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
        // send command to queue to send email
        dispatch(new SendNewPostEmail([
            'sendTo'=>auth()->user()->email,
            'name' => auth()->user()->username,
            'title' => $newPost->title 
        ]));
        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created.');
    }
}
