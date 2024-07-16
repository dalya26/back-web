<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/prueba',[App\Http\Controllers\PostController::class, 'index1'])->name("pruebitaView");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    //User
    Route::get('/selectUser',[UserController::class, 'selectUser']);
    Route::get('/us',[UserController::class, 'index']);
    Route::get('/usa', [AuthController::class, 'usa']);

	// Post
    Route::get('/posts', [PostController::class, 'index']); // all posts
    Route::post('/createP', [PostController::class, 'store']); // create post
    Route::get('/seeOne/{id}', [PostController::class, 'show']); // get single post
    Route::post('/updateP', [PostController::class, 'update']); // update post
    Route::get('/selectImage',[PostController::class, 'selectPost']);
    Route::get('/selectUsa',[PostController::class, 'selectUser']); //User
    Route::delete('/deleteP/{id}', [PostController::class, 'destroy']); // delete post
    Route::post('/insertImage',[PostController::class, 'insertImage']);
    Route::post('/updateImage',[PostController::class, 'updateImage']);
    Route::delete('/deleteImage/{id}',[PostController::class, 'deleteImage']);

    // Comment
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
    Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment
    Route::get('/selectComent',[CommentController::class, 'selectComent']);
    Route::post('/insertComent',[CommentController::class, 'insertComent']);
    Route::post('/updateComent',[CommentController::class, 'updateComent']);
    Route::delete('/deleteComent/{id}',[CommentController::class, 'deleteComent']);


    // Like
    Route::post('/like/{id}', [PostController::class, 'liked']); // like or dislike back a post
});

