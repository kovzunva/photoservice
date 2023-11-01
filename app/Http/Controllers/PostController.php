<?php

// app/Http/Controllers/postController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HelperController;
use Carbon\Carbon;

class PostController extends Controller
{

    public function showAll(Request $request, $page = 1)
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        foreach ($posts as $post) {
            $post->img = HelperController::getImg('post', $post->id);
        }
        $paginator = HelperController::paginator($posts, 'postPage', $page, 3);

        return view(
            'client.main-page',
            [
                'posts' => $paginator['data'],
                'paginator' => $paginator['paginator'],
                'title' => "Пости",
            ]
        );
    }

    public function emptyForm()
    {
        return view(
            'client.post-form',
            [
                'post' => null,
                'title' => "Додавання Посту",
            ]
        );
    }

    public function add(Request $request)
    {
        $error = '';
        try {
            $post = Post::create([
                'name' => $request['name'],
                'about' => $request['about'],
                'user_id' => auth()->id(),
            ]);
        } catch (Exception $e) {
            $error = 'Помилка при вставці даних. ';
        }

        // Картинка
        try {
            $img = $request->input('img_pass');
            if ($img) {
                $mes = HelperController::saveImg($img, 'post', $post->id);
                if ($mes != '')
                    $error .= $mes . ' ';
            }
        } catch (\Exception $e) {
            $error .= 'Помилка при обробці зображення. ';
        }


        if ($error != '')
            return redirect()->back()->with('error', $error);
        else
            return redirect()->route('post', ['id' => $post->id])->with('success', 'Пост успішно створено!');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $img = HelperController::getImg('post', $post->id);

        return view('client.post', [
            'post' => $post,
            'img' => $img,
            'title' => 'Пост',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return redirect()->back()->with('error', 'Пост не знайдено.');
        }
        $error = '';
        if ($request->isMethod('post')) {
            try {
                $post->update([
                    'name' => $request['name'],
                    'about' => $request['about'],
                ]);

                // Картинка
                try {
                    $img = $request->input('img_pass');
                    if ($img) {
                        HelperController::delImg(HelperController::getImg('post', $post->id));
                        $mes = HelperController::saveImg($img, 'post', $post->id);
                        if ($mes != '')
                            $error .= $mes . ' ';
                    }
                } catch (\Exception $e) {
                    $error .= 'Помилка при обробці зображення. ';
                }

                return redirect()->route('post', ['id' => $post->id])->with('success', 'Зміни внесено успішно.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Помилка при збереженні змін.');
            }
        } else {
            $img_edit = HelperController::getImg('post', $post->id);
            return view('client.post-form', [
                'post' => $post,
                'img_edit' => $img_edit,
                'title' => "Редагування Посту",
            ]);
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('my-posts')->with('success', 'Пост успішно видалено!');
    }

    public function search(Request $request,$page=1)
    {
        // Отримайте запит введення користувача
        $search = $request->input('search');

        // Виконайте пошук постів
        $posts = Post::where('name', 'like', "%$search%")
            ->orWhere('about', 'like', "%$search%")
            ->get();
        foreach ($posts as $post) {
            $post->img = HelperController::getImg('post', $post->id);
        }
        $paginator = HelperController::paginator($posts, 'postPage', $page, 3);

        // Передайте результат пошуку в представлення
        return view('client.main-page', [
            'search' => $search,
            'posts' => $paginator['data'],
            'paginator' => $paginator['paginator'],
        ]);
    }
}
