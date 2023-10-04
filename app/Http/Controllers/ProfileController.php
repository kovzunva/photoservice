<?php

// app/Http/Controllers/BlogController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\BlogPost;
// use App\Models\User;
use app\Http\Controllers\Auth;

class ProfileController extends Controller
{

    public function myProfile()
    {
        $user = auth()->user();
        return view('client.my-profile', [
            'user' => $user,
            'title' => 'Персональний кабінет',
        ]);
    }

    public function showAll()
    {
        
        return view('client.profiles', 
        [
            'profiles' => $paginator['data'],
            'paginator' => $paginator['paginator'],
            'title' => "Користувачі",
        ]);
    }

    // public function blogForm()
    // {
    //     $user = auth()->user();
    //     return view('client.blog-form', [
    //         'user' => $user,
    //         'blog' => null,
    //         'title' => 'Персональний кабінет',
    //     ]);
    // }

    // public function editProfile()
    // {
    //     $user = auth()->user();
    //     return view('cabinet.editProfile', compact('user'));
    // }

    // public function updateProfile(Request $request)
    // {
    //     $user = auth()->user();
    //     $user->update($request->all());
    //     return redirect()->route('cabinet.profile')->with('success', 'Профіль успішно оновлено.');
    // }

}

