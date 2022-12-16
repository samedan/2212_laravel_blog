<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    //
    public function homepage() {
        // Blade file in /resources/views
        return view('homepage');
    }
    public function aboutPage() {
        return view('single-post');
    }
}
