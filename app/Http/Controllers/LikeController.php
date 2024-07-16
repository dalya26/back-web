<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    // like or unlike
    public function likeOrUnlike($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => 'Post not found.'
            ], 403);
        }

        $like = $post->likes()->where('user_id', auth()->user()->id)->first();

        // if not liked then like
        if (!$like) {
            Like::create([
                'post_id' => $id,
                'user_id' => auth()->user()->id
            ]);

            return response([
                'message' => 'Liked'
            ], 200);
        }
        // else dislike it
        $like->delete();

        return response([
            'message' => 'Disliked'
        ], 200);
    }

    public function likePost(Request $request)
    {
        $user = $request->user();

        // Verificar si el ID del post está presente en la solicitud
        $postId = $request->input('post_id');
        if (!$postId) {
            return response()->json(['error' => 'Post ID is required'], 400);
        }

        // Verificar si el usuario ya dio like al post
        if ($user->likes()->where('post_id', $postId)->exists()) {
            return response()->json(['error' => 'Already liked'], 400);
        }

        // Crear el like
        $like = new Like();
        $like->user_id = $user->id;
        $like->post_id = $postId;
        $like->save();

        return response()->json(['message' => 'Post liked successfully'], 200);
    }

    public function likePoste(Request $request)
    {
        $user = auth()->user();

        // Verificar si el usuario ya dio like a esta publicación
        $like = Like::where('user_id', $user->id)
            ->where('post_id', $request->post_id)
            ->first();

        if ($like) {
            $like->delete(); // Si ya dio like, se elimina
        } else {
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $request->post_id;
            $like->save(); // Si no dio like, se crea un nuevo like
        }

        // Obtener el conteo de likes para esta publicación
        $likeCount = Like::where('post_id', $request->post_id)->count();

        return response()->json(['likeCount' => $likeCount]);
    }
}
