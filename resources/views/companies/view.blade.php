@extends('layouts.app')
@section('title', 'View '.$company['name'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <u>
                        {{$company['name']}}
                    </u>
                </div>
                <a href="/companies" class="text-decoration-none text-dark">
                    <div class="d-flex mt-2 justify-content-center">
                        <p class="text-center">All companies</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
                        </svg>
                    </div>
                </a>
                <div class="d-flex justify-content-center">
                    {{-- EDIT BUTTON --}}
                    <form action="/companies/edit/{{ $company['id'] }}" method="get">
                        <button companyName="{{ $company['name'] }}" class="EditCompany btn text-primary text-decoration-none" data-toggle="tooltip" data-placement="top" title="Edit Company">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                        </button>                 
                    </form>
                    <form action="/companies/delete/{{ $company['id'] }}" method="post">
                        @csrf
                        @method("DELETE")   
                        {{-- DELETE BUTTON --}}
                        <button id="DeleteBtn" type="submit" class="btn text-danger text-decoration-none" data-toggle="tooltip" data-placement="top" title="Delete Company">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="card-body text-center">
                    @if ($company['logo'])   
                        <div>
                            <img 
                                src="/storage/{{ $company['logo'][0]['image_path'] }}" 
                                alt="ela"
                                class="w-25"
                                >
                            </div>
                    @endif
                    <h1 class="text-center">{{ $company['name'] }}<span class="h6">(#{{$company['id']}})</span> </h1>
                    <div class="row m-2">
                        <div class="col-lg-1 w-25 text-start">
                            <span class="h4">Games: </span>
                        </div>
                        <div class="col text-start">
                            @foreach ($games as $game)
                                <a href="/games/view/{{ $game['id'] }}">{{ $game['name'] }}</a>,
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', "#DeleteBtn" , function (e){
        if (!confirm('This Tag will be deleted.\n Are you Sure?')) {
            e.preventDefault();
        }
    })
</script>
@endsection
