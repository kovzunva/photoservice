<?php

// app/Http/Controllers/BlogController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use app\Http\Controllers\Auth;
use App\Http\Controllers\HelperController;

class ProfileController extends Controller
{

    public function myProfile()
    {
        $user = auth()->user();
        $posts = Post::orderBy('created_at', 'desc')->where('user_id',auth()->id())->get();
        foreach ($posts as $post) {
            $post->img = HelperController::getImg('post',$post->id);
        }
        return view('client.my-profile', [
            'user' => $user,
            'posts' => $posts,
            'title' => 'Персональний кабінет',
        ]);
    }

}

