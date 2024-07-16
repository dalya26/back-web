<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

use Exception;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{

    public function index1()
    {
        return view('pages.weblog');
    }


    // get all posts
    public function index()
    {
        return response([
            'posts' => Post::orderBy('created_at', 'desc')->with('user:id,name,image')->withCount('comments', 'likes')
                ->with('likes', function ($like) {
                    return $like->where('user_id', auth()->user()->id)
                        ->select('id', 'user_id', 'post_id')->get();
                })
                ->get()
        ], 200);
    }

    //post
    public function selectPost()
    {
        return Post::all();
    }

    public function selectPosts()
    {
        //$post = Post::all();
        $posts = Post::orderBy('created_at', 'desc')
            ->with('user:id,name,image')
            ->withCount('comments', 'likes')
            ->get()
            ->map(function ($post) {
                $post->user->image = asset('storage/posts/' . $post->user->image);
                return $post;
            });

        return response()->json(['posts' => $posts], 200);
    }

    //user
    public function selectUser()
    {
        return User::all();
    }

    // get single post
    public function show($id)
    {
        return response([
            'post' => Post::where('id', $id)->withCount('comments', 'likes')->get()
        ], 200);
    }

    // create a post
    public function store(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'body' => 'required|string'
        ]);

        $image = $this->saveImage($request->image, 'posts');

        $post = Post::create([
            'title' => $attrs['title'],
            'body' => $attrs['body'],
            'user_id' => auth()->user()->id,
            'image' => $image
        ]);

        // for now skip for post image

        return response([
            'message' => 'Post created.',
            'post' => $post,
        ], 200);
    }

    // update a post
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        if ($post->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        //validate fields
        $attrs = $request->validate([
            'body' => 'required|string'
        ]);

        $post->update([
            'title' =>  $attrs['title'],
            'body' =>  $attrs['body']
        ]);

        // for now skip for post image

        return response([
            'message' => 'Post updated.',
            'post' => $post
        ], 200);
    }

    //delete post
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        if ($post->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        $post->comments()->delete();
        $post->likes()->delete();
        $post->delete();

        return response([
            'message' => 'Post deleted.'
        ], 200);
    }

    // prueba de insercion en la web
    public function insertImage(Request $request)
    {
        if($request->id == 0){
            $post = new Post();
        }
        else {
            $post = Post::find($request->id);
        }
        try {
            //$post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->user_id = Auth::user()->id;
            //if($request->file('foto')!=null){
            $post->image = $request->file('image')->store('posts', 'public');
            //}
            $post->save();
            return $post;
        } catch (Exception $e) {
            Log::debug('Metodo INSERT clase PostCONTROLLER->' . $e->getMessage());
        }
    }

    public function post(Request $request){
        //Segundo Try-Catch
        try{
            $post = Post::find($request->id);
            return $post;
        }catch(Exception $e){
            Log::error('Metodo show clase PostController->' .$e->getMessage());
        
        }

    }

    public function showpost($id)
    { 
       $post = Post::find($id);

       if(!$post){
         return response()->json([
            'message'=>'Post Not Found.'
         ],404);
       }
      
       // Return Json Response
       return response()->json([
          'posts' => $post
       ],200);
    }
    


//def
    public function insertImage1(Request $request)
    {
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->user_id = Auth::user()->id;
            //if($request->file('foto')!=null){
            $post->image = $request->file('image')->store('posts', 'public');
            //}
            $post->save();
        } catch (Exception $e) {
            Log::debug('Metodo INSERT clase PostCONTROLLER->' . $e->getMessage());
        }
    }

    public function updateImage(Request $request, $id) //actualizar publicacion 
    {
        try {
            $post = Post::find($id);
            $post->title = $request->title;
            $post->body = $request->body;
            $post->user_id = Auth::user()->id;
            //Valida si existe una modificación de la imagen, sino no realizara modificación ni eliminación de imagen anterior
            if ($request->file('image') != null) {
                /*A continuación, deberás validar el correcto funcionamiento de la eliminación de la imagen anterior
                , la vez anterior no funciono por la ruta relativa que nos arroja*/
                Storage::disk('public')->delete($post->image);
                /**/
                $post->image = $request->file('image')->store('posts', 'public');
            }
            $post->save();
        } catch (Exception $e) {
            Log::debug('Metodo UPDATE clase PostCONTROLLER->' . $e->getMessage());
        }
    }

    public function deleteImage($id)
    {
        try {
            $post = Post::find($id);
            //Cuando elimina un registro, no elimina los archivos del servidor, si funciono la linea del update DEJARLA ASÍ
            // SINO MODIFICAR A LA SOLUCIÓN ENCONTRADA
            Storage::disk('public')->delete($post->image);
            //
            $post->delete();
        } catch (Exception $e) {
            Log::debug('Metodo DELETE clase PostCONTROLLER->' . $e->getMessage());
        }
    }

    public function updatepost(PostStoreRequest $request, $id)
    {
        try {
            // Find product
            $post = Post::find($id);
            if (!$post) {
                return response()->json([
                    'message' => 'posts Not Found.'
                ], 404);
            }

            //echo "request : $request->image";
            $post->title = $request->title;
            $post->body = $request->body;

            if ($request->image) {

                // Public storage
                $storage = Storage::disk('public');

                // Old iamge delete
                if ($storage->exists($post->image))
                    $storage->delete($post->image);

                // Image name
                $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();
                $post->image = $imageName;

                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->image));
            }

            // Update posts
            $post->save();

            // Return Json Response
            return response()->json([
                'message' => "posts successfully updated."
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }

    public function eliminar(Request $request)
    {
        try{
            $post = Post::find($request->id);
            $post ->delete();
        }catch(Exception $e){
            Log::error('Metodo Borrar clase PostController->' .$e->getMessage());
        
        }
    }

   
    public function liked()
    {
        
        $post = Post::find(request()->id);

        if($post->isLikedByLoggedInUser()){
            //dislike
            $result = Like::where([
                'user_id' => auth()->user()->id,
                'post_id' => request()->id
            ])->delete();
            return response()->json(['message' => 'Liked successfully'], 200);

        }else{
            //like
            $like = new Like();
            $like->user_id = auth()->user()->id;
            $like->post_id = request()->id;
            $like->save();
            return response()->json([
                'count' =>Post::find(request()->id)->likes->count(),
            ], 200);
        }

    }

}
