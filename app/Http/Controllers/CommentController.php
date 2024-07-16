<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Exception;

class CommentController extends Controller
{
    // get all comments of a post
    public function index($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        return response([
            'comments' => $post->comments()->with('user:id,name,image')->get()
        ], 200);
    }

    // create a comment
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        //validate fields
        $attrs = $request->validate([
            'comment' => 'required|string'
        ]);

        Comment::create([
            'comment' => $attrs['comment'],
            'post_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        return response([
            'message' => 'Comment created.'
        ], 200);
    }

    // update a comment
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response([
                'message' => 'Comment not found.'
            ], 403);
        }

        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        //validate fields
        $attrs = $request->validate([
            'comment' => 'required|string'
        ]);

        $comment->update([
            'comment' => $attrs['comment']
        ]);

        return response([
            'message' => 'Comment updated.'
        ], 200);
    }

    // delete a comment
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response([
                'message' => 'Comment not found.'
            ], 403);
        }

        if ($comment->user_id != auth()->user()->id) {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        $comment->delete();

        return response([
            'message' => 'Comment deleted.'
        ], 200);
    }

    //prueba web 
    public function selectComent()
    {
        try {
            $comments = Comment::orderBy('created_at', 'desc')
                ->with('user:id,name')
                ->get();

            return response()->json(['comments' => $comments], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function insertComent(Request $request)
    {
        try {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->post_id = $request->post_id;
            $comment->user_id = Auth::user()->id;
            $comment->save();
        } catch (Exception $e) {
            Log::debug('Metodo INSERT clase CommentCONTROLLER->' . $e->getMessage());
        }
    }

    public function updateComent(Request $request)
    {
        try {
            $comment = Comment::find($request->id);
            $comment->comment = $request->comment;
            $comment->post_id = $request->post_id;
            $comment->user_id = Auth::user()->id;
            $comment->save();
        } catch (Exception $e) {
            Log::debug('Metodo UPDATE clase CommentCONTROLLER->' . $e->getMessage());
        }
    }


    public function deleteComent($id)
    {
        try {
            $comment = Comment::find($id);
            $comment->delete();
        } catch (Exception $e) {
            Log::debug('Metodo DELETE clase CommentCONTROLLER->' . $e->getMessage());
        }
    }

    //function react
    public function create(Request $request)
    {
        if ($request->id == 0) {
            $comment = new Comment();
        } else {
            $comment = Comment::find($request->id);
        }
        try {

            $post = Post::findOrFail($request->post_id);

            $comment->comment = $request->comment;
            $comment->post_id = $post->id;
            $comment->user_id = Auth::user()->id;
            $comment->save();

            return redirect()->route('posts', $post->id);
            return $comment;
        } catch (Exception $e) {
            Log::debug('Metodo INSERT clase CommentCONTROLLER->' . $e->getMessage());
        }
    }

    public function comments(Request $request)
    {
        try {
            $comments = Comment::orderBy('created_at', 'desc')
                ->with('user:id,name')
                ->get();


            return $comments;
            //return response()->json(['comments' => $comments], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        /**try {
            $comments = Comment::orderBy('created_at', 'desc')
                ->with('user:id,name')
                ->get();

            return response()->json(['comments' => $comments], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }*/
    }

    public function comment($id)
    {
        //Segundo Try-Catch
        try {
            $comment = Comment::find($id);
            return $comment;
        } catch (Exception $e) {
            Log::error('Metodo Comment clase CommentController->' . $e->getMessage());
        }
    }

    public function eliminar(Request $request)
    {
        try {
            $comment = Comment::find($request->id);
            $comment->delete();
        } catch (Exception $e) {
            Log::debug('Metodo DELETE clase CommentCONTROLLER->' . $e->getMessage());
        }
    }




    public function showComent()
    {
        ///return Comment::all();

        try {
            $comment = Comment::orderBy('created_at', 'desc')
                ->with('user:id,name')
                ->get();

            return response()->json(['comments' => $comment], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


        // All Product
        /**$comment = Comment::all();
      
       // Return Json Response
       return response()->json([
          'comments' => $comment
       ],200);*/
    }

    public function indexes()
    {
        // All Product
        $comment = Comment::all();

        // Return Json Response
        return response()->json([
            'comments' => $comment
        ], 200);
    }

    public function indext(Request $request)
    {
        if ($request->input('post_id')) {
            $comment = Comment::with('user', 'post')
                ->where('approved', 1)
                ->where('post_id', $request->input('post_id'))
                ->paginate(10);
        } else {
            $comment = Comment::with('user', 'post')->orderBy('id', 'desc')->paginate(10);
        }

        return response()->json(['comments' => $comment], 200);
    }


    //vercoments en post
    public function showCommentsByPostee($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $comments = Comment::where('post_id', $id)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['comments' => $comments]);
        //return redirect()->route('posts.show', $post->$id);
    }

    public function storeComment(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->post_id = $validatedData['post_id'];
        $comment->comment = $validatedData['comment'];
        $comment->user_id = auth()->id(); // Asigna el ID del usuario actual que está haciendo el comentario

        $comment->save();

        return response()->json(['message' => 'Comentario registrado correctamente'], 201);
    }


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function storedt(Request $request, Post $post)
    {
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = \auth()->id();

        $post->comments()->save($comment);

        return \redirect()->route('posts.show', $post);
    }
}
