@extends('layouts.app')

@section('content')
    <h2>Персональний кабінет</h2>
    <div class="row col-lg-8 col-md-12">
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
        
        <ul>					
            <li><a href="/profile/blogs">Мої блоги</a></li>
        </ul>
    </div>	
@endsection	