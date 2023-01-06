@extends('layouts.app')

@section('content')
<h1 class="text-center">{{ $game['name'] }}</h1>
{{-- RETURN TO ALL GAMES LINK --}}
<div class="d-flex row justify-content-center">
    <a href="/games" class="btn btn-sm btn-light w-25 text-decoration-none text-dark">
        <div class="d-flex justify-content-center">
            <p class="text-center">All games</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
            </svg>
        </div>
    </a>
</div>
{{-- RETURN TO GAME VIEW --}}
<div class="d-flex row justify-content-center">
    <a href="/games/view/{{ $game['id'] }}" class="btn btn-sm btn-light w-25 text-decoration-none text-dark">
        <div class="d-flex justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M14.854 4.854a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 4H3.5A2.5 2.5 0 0 0 1 6.5v8a.5.5 0 0 0 1 0v-8A1.5 1.5 0 0 1 3.5 5h9.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4z"/>
            </svg>
            <p class="text-center">{{ $game['name'] }}</p>
        </div>
    </a>
</div>
{{-- IMAGES TO DELETE --}}
<div class="container-fluid">
    <div class="row justify-content-center">
        @foreach ($images as $image)
        <div class="card m-2 text-center" style="width: 20rem;">
            <div class="card-body">
            <img class="w-100" src="/storage/{{$image['image_path']}}" alt="dsds">
            <a href="/games/removeimages/{{$image['id']}}" class="delete-img btn btn-lg btn-danger mt-2">DELETE</a>
        </div>
        </div>
        @endforeach
    </div>
</div>
@endsection