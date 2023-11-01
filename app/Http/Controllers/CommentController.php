<?php

// app/Http/Controllers/CommentController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function add(Request $request)
    {
        // Створення нового коментаря
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->user()->id;
        $comment->blog_id = $request->input('blog_id');
        $comment->save();

        return redirect()->back()->with('success', 'Коментар додано успішно.');
    }

    public function edit(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'Ви не можете редагувати цей коментар.');
        }
        
        $comment->content = $request->input('edit_content');
        $comment->save();

        return redirect()->back()->with('success', 'Коментар відредаговано успішно.');
    }

    public function del($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'Ви не можете видалити цей коментар.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Коментар видалено успішно.');
    }
}

