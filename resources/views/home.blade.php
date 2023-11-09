@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="my-card p-3">
                <div class="container text-center">
                    <h2>Вхід</h2>
                </div>

                <hr>


                <div class="text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Ви зареєструвались!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
