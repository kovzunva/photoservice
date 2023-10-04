<?php

// app/Http/Controllers/BlogController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HelperController;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function paginate(Request $request, $table)
    {
        // Отримуємо кількість записів на сторінку (якщо вказано)
        $perPage = $request->input('per_page', 2);

        // Вибираємо дані з вказаної таблиці та робимо пагінацію
        $data = DB::table($table)->paginate($perPage);

        return $data;
    }
    
    public function showAll(Request $request, $page=1){
        $query = Blog::orderBy('created_at', 'desc');

        $selectedCategory = new BlogCategory();
        if ($request->has('category')) {
            $categoryFilter = $request->input('category');
            if ($categoryFilter === 'all') $selectedCategory->name = 'Всі категорії';
            elseif ($categoryFilter === '') {
                $query->where('category_id', '');
                $selectedCategory->name = 'Інше';
            }
            else {
                $query->where('category_id', $categoryFilter);
                $selectedCategory = BlogCategory::find($request->input('category'));
            }
        }

        $selectedDateFrom = null;
        $selectedDateTo = null;
        try{
            if ($request->has('date_from') && $request->input('date_from')!='') {
                $dateFromFilter = $request->input('date_from');
                $carbonDate = Carbon::createFromFormat('d.m.Y', $dateFromFilter)->format('d.m.Y');
                if ($carbonDate==$dateFromFilter){
                    $dateFromFilter = Carbon::createFromFormat('d.m.Y', $dateFromFilter)->format('Y-m-d');
                    $query->whereDate('created_at', '>=', $dateFromFilter);
                    $selectedDateFrom = Carbon::createFromFormat('Y-m-d', $dateFromFilter)->format('d.m.Y');
                }
            }
        }
        catch(\Exception $e){}
        try{
            if ($request->has('date_to') && $request->input('date_to')!='') {
                $dateToFilter = $request->input('date_to');
                $carbonDate = Carbon::createFromFormat('d.m.Y', $dateToFilter)->format('d.m.Y');
                if ($carbonDate==$dateToFilter){
                    $dateToFilter = Carbon::createFromFormat('d.m.Y', $dateToFilter)->format('Y-m-d');
                    $query->whereDate('created_at', '<=', $dateToFilter);
                    $selectedDateTo = Carbon::createFromFormat('Y-m-d', $dateToFilter)->format('d.m.Y');
                }
            }
        }
        catch(\Exception $e){}

        $blogs = $query->get();
        $paginator = HelperController::paginator($blogs,'blogPage',$page,3);        
        $categories = BlogCategory::orderBy('name')->get();

        return view('client.blogs', 
        [
            'blogs' => $paginator['data'],
            'paginator' => $paginator['paginator'],
            'categories' => $categories,
            // фільтри
            'selectedCategory' => $selectedCategory,
            'selectedDateFrom' => $selectedDateFrom,
            'selectedDateTo' => $selectedDateTo,
            'title' => "Блоги",
        ]);
    }

    public function usersBlogs(){
        $userId = auth()->user()->id;
        $blogs = Blog::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('client.my-blogs', [
            'blogs' => $blogs,
            'title' => "Блоги користувача",
        ]);
    }


    public function emptyForm(){
        $categories = BlogCategory::orderBy('name')->get();
        return view('client.blog-form', 
        [
            'blog' => null,
            'categories' => $categories,
            'title' => "Додавання блогу",
        ]);
    }

    public function add(Request $request){
        $error = '';
        try {
            $blog = Blog::create([
                'title' => $request['title'],
                'content' => $request['content'],
                'category_id' => $request['category_id'],
                'user_id' => auth()->id(),
            ]);
        }
        catch (\Exception $e) {
            $error = 'Помилка при вставці даних. ';
        }


        if ($error!='') return redirect()->back()->with('error', $error);
        else return redirect()->route('blog', ['id' => $blog->id])->with('success', 'Блог успішно створено!');
    }

    public function show($id){
        $blog = Blog::findOrFail($id);

        return view('client.blog', [
            'blog' => $blog,
            'title' => 'Літературний блог',
        ]);
    }

    public function edit(Request $request, $id){
        $blog = Blog::findOrFail($id);

        if (!$blog) {
            return redirect()->back()->with('error', 'Блог не знайдено.');
        }

        if ($request->isMethod('post')) {
            try {
                $blog->update([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'category_id' => $request->input('category_id'),
                ]);

                return redirect()->route('blog', ['id' => $blog->id])->with('success', 'Зміни внесено успішно.');
            }
            catch (\Exception $e) {
                return redirect()->back()->with('error', 'Помилка при збереженні змін.');
            }
        }
        else {
            $categories = BlogCategory::orderBy('name')->get();
            return view('client.blog-form', [
                'blog' => $blog,
                'categories' => $categories,
                'title' => "Редагування блогу",
            ]);
        }
    }

    public function destroy($id){
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('my-blogs')->with('success', 'Блог успішно видалено!');
    }   
}

