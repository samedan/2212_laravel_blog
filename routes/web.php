<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin Routes
Route::get('/admins-only', function() {
  return 'Only visible for admins';
})->middleware('can:visitAdminPages');

// User Routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
// the '->name('login')' with the middleware '->middleware('auth')' redirects to login page
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, "storeAvatar"])->middleware('mustBeLoggedIn');
// Follow related Routes
Route::post('/create-follow/{user:username}',[FollowController::class, 'createFollow'])->middleware('mustBeLoggedIn');
Route::post('/remove-follow/{user:username}',[FollowController::class, 'removeFollow'])->middleware('mustBeLoggedIn');
// Post Routes
Route::get('/create-post', [PostController::class, "showCreateForm"])->middleware('mustBeLoggedIn');// middleware class comes from Kernel.php
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, "viewSinglePost"]);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');
// Profile Routes
Route::get('/profile/{user:username}', [UserController::class, 'profile']);
