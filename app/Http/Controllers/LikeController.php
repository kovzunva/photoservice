<?php

// app/Http/Controllers/BlogController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function like(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Необхідно увійти в систему.'], 401);
        }
        try {
            $post_id = $request->input('item_id');
            $user_id = auth()->user()->id;

            $is_liked = DB::select("SELECT post_id FROM likes
                                    WHERE post_id = $post_id  and user_id = $user_id");

            if (count($is_liked) > 0) {
                DB::table('likes')
                    ->where('post_id', $post_id)
                    ->where('user_id', $user_id)
                    ->delete();
                return response()->json(['success' => true, 'message' => 'Вподобайку успішно видалено. ', 'liked' => false]);
            } else
                DB::table('likes')->insert([
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                ]);

            return response()->json(['success' => true, 'message' => 'Вподобайку успішно додано. ', 'liked' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Помилка при обробці вподобайки. ' . $e->getMessage()]);
        }
    }

}

