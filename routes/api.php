<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DescripController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use Symfony\Component\CssSelector\Parser\Handler\CommentHandler;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/regus', [AuthController::class, 'regus']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/prueba',[UserController::class, 'index1'])->name("pruebitaView");

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function() {

    // User
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/userupdate', [AuthController::class, 'updateProfile']);
    Route::get('/usuario', [PostController::class, 'usuario']); //post

    // Post
    Route::get('/posts', [PostController::class, 'index']); // all posts
    Route::post('/posts', [PostController::class, 'store']); // create post
    Route::get('/postsone/{id}', [PostController::class, 'show']); // get single post
    Route::put('/posts/{id}', [PostController::class, 'update']); // update post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete post

    // Comment
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
    Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

    // Like
    Route::post('/like', [LikeController::class, 'likePost']); // like or dislike back a post



    //postsnew react
    Route::get('/selectImage',[PostController::class, 'selectPosts']);//mostrar post
    Route::post('/insertImage',[PostController::class, 'insertImage']);//crear-edit posts
    Route::get('/postess', [PostController::class, 'post']); //post
    Route::post('/eliminar',[PostController::class, 'eliminar']); //eliminar 

    Route::get('/postson/{id}', [PostController::class, 'showpost']);//post get one
    Route::get('/selectUsa',[PostController::class, 'selectUser']); //User


    // Comment react
    Route::get('/mComment/{id}',[CommentController::class, 'showCommentsByPostee']);//mostrar comments
    Route::post('/cComment',[CommentController::class, 'create']);//crear-edit comment
    Route::resource('comments', 'CommentController');
    Route::get('/poste/{post}', [PostController::class, 'showed'])->name('posts.show');
    Route::post('/commentsss', [CommentController::class, 'storedt']);

    //User edit
    Route::put('/updateus', [AuthController::class, 'updateus']);
    Route::get('/showuser', [AuthController::class, 'userid']);//ver usuario login
    Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth');
    Route::get('/usa', [AuthController::class, 'usa']);//todos los usuarios menos el login

    Route::put('/updateperfil/{id}', [AuthController::class, 'updateProfile']);//editar perfil de usuario

    //descrip user
    Route::get('/descshow',[DescripController::class, 'index']);
    Route::post('/descreate',[DescripController::class, 'create']);
    Route::post('/eliminardesc',[DescripController::class, 'delete']);

    Route::get('/mDescr/{id}',[DescripController::class, 'showInfoByUser']);

    //likenew 
    Route::post('/likes', [LikeController::class, 'likePoste']); // like or dislike back a post

});