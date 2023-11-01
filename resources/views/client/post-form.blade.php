@extends('layouts.app')



@section('aside')	

@endsection



@section('content')	

    <header class="">
        <h2>Форма {{ $post ? 'редагування' : 'додавання' }} посту</h2>
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


    <form action="/profile/post/{{ $post ? $post->id.'/edit' : 'add' }}" method="POST" id="post-form"
        class="validate-form">
        @csrf

        <div class="mb-3">
            <label for="" class="form-label">Назва</label>
            <div class="error-text hide" id="error_name">Заповніть поле</div>
            <input type="text" name="name" value="{{ $post ? $post->name : '' }}" class="required">
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Опис</label>
            <textarea name="about" rows="2">{{ $post ? $post->about : '' }}</textarea>
        </div>  

        {{-- Картинка --}}
        <div class="mb-3">
            <label for="" class="form-label">Додайте зображення</label>
            <div class="mb-3">
                <input type="file" id="file_img" accept="image/*">
            </div>
            <div class="input-group mb-3">
                <input type="text" class="input-with-btt enter_btn" id="url_img" placeholder="URL зображення">
                <button class="btn btn-outline-secondary btt-with-input" type="button" id="btn_url_img">Додати</button>
            </div>

            <div class="container mb-3">
                <input type="hidden" name="img_pass" value="" id="img_pass">
                <div class="img_preview" id="container_img">                                   
                    <img src="{{ $post && $img_edit? asset($img_edit):'' }}" alt="картинка" id='post_img'>
                </div>
            </div>
        </div>                        

        <div class='text-end'>
            <input type="submit" name="submit" class="base-btn" value="Опублікувати">
        </div>
    </form>    

<script src="https://cdn.tiny.cloud/1/tatyegaul1dl88btgari4jz7c7st2hz44mxb4kck1c4rvzip/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> 


@endsection
	