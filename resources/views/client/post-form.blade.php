@extends('layouts.app')



@section('aside')	

@endsection



@section('content')	

    <header class="">
        <h2>Форма {{ $blog ? 'редагування' : 'додавання' }} блогу</h2>
    </header>

    {{-- Повідомлення --}}
    @if(session('error'))
        <div class="div-error mb-3">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="div-success mb-3">
            {{ session('success') }}
        </div>
    @endif


    <form action="/profile/blog/{{ $blog ? $blog->id.'/edit' : 'add' }}" method="POST" id="blog-form"
        class="validate-form">
        @csrf

        <div class="mb-3">
            <label for="" class="form-label">Назва</label>
            <div class="error-text hide" id="error_name">Заповніть поле</div>
            <input type="text" name="title" value="{{ $blog ? $blog->title : '' }}" class="required">
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Категорія</label>
            <div class="base-select">
                <div class="select-box">
                    <span class="selected-option d-flex align-items-center">
                    {{ $blog && $blog->category ? $blog->category->name : 'Інше' }}
                    <i class="fa-solid fa-angle-down ml-auto"></i></span>
                    <ul class="options hide">
                    <li data-value="">Інше</li>
                    @foreach ($categories as $category)
                        <li data-value="{{ $category->id }}">{{ $category->name }}</li>
                    @endforeach
                    </ul>
                </div>
                <input type="hidden" name="category_id" value="{{ $blog ? $blog->category_id : '' }}">
            </div>     
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Текст</label>
            <textarea name="content" rows="15" id="blog_content">{{ $blog ? $blog->content : '' }}</textarea>
        </div>                             

        <div class='text-end'>
            <input type="submit" name="submit" class="base-btn" value="Опублікувати">
        </div>
    </form>    

<script src="https://cdn.tiny.cloud/1/tatyegaul1dl88btgari4jz7c7st2hz44mxb4kck1c4rvzip/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> 
@vite('resources/js/specified.js')  

@endsection
	