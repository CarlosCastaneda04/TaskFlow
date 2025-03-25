<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Obtener todos los comentarios
    public function index()
    {
        return Comment::with(['user', 'task'])->get();
    }

    // Crear un nuevo comentario
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $comment = Comment::create($request->all());
        return response()->json($comment, 201);
    }

    // Ver un comentario específico
    public function show(Comment $comment)
    {
        return $comment->load(['user', 'task']);
    }

    // Actualizar un comentario
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($request->all());
        return response()->json($comment);
    }

    // Eliminar un comentario
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }
}
