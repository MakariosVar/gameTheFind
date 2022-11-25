@extends('layouts.app')
@section('title', 'Categories')
@section('content')
<div class="w-100">
    <div id="MainPage" class="row justify-content-center">
        <h1 class="text-center">CATEGORIES</h1>
        <div class="col-md-8 border rounded p-2">
            <h4 class="text-center">Create new category</h4>
            <div class="border p-1">
                <br>
                @if($errors->any())
                <h4 class="text-center italic text-danger">{{$errors->first()}}</h4>
                @endif
                <form method="post" id="CategoryForm" class="d-flex justify-content-center" action="{{url('categories/store')}}">
                    @csrf
                    <div class="input-group mb-3 w-50">
                        <input type="text" name="categoryName" id="CategoryName" placeholder="New category" class="text-center form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                        <button type="submit" class="btn btn-info">Create</button>
                    </div>
                </form>    
            </div>
            <div class="border mt-3 table-responsive">
                @if ($query)
                    <h3 class="text-center">Searching key: {{$query}}</h3>
                    <h6 class="text-center">
                        <a href="/categories">clear filter</a>
                    </h6>
                @endif
                <div class="d-flex justify-content-center">
                    <form action="/categories/search" method="post">
                        @csrf
                        <div class="input-group input-group-sm m-2">
                            <input type="text" name="categoryQuery" class="form-control" placeholder="Search...">
                            <button type="submit" class="btn btn-warning">Search</button>
                        </div>
                    </form>
                </div>
                <table class="table table-striped border">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="w-75 text-center">Name</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($categories) === 0) 
                            @php
                                echo 'den exw'; 
                            @endphp
                        @endif
                        @foreach ($categories as $key => $category)
                        <tr>
                            <th scope="row">{{ $key+1 }}</th>
                            <td class="w-75 text-center">{{ $category['name'] }}</td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    {{-- EDIT BUTTON --}}
                                    <button id="{{ $key." ".$category['id'] }}" categoryName="{{ $category['name'] }}" class="EditCategory btn text-primary text-decoration-none" data-toggle="tooltip" data-placement="top" title="Edit Category">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </button>                 
                                    <form action="/categories/delete/{{ $category['id'] }}" method="post">
                                        @csrf
                                        @method("DELETE")   
                                        {{-- DELETE BUTTON --}}
                                        <button id="DeleteBtn" type="submit" class="btn text-danger text-decoration-none" data-toggle="tooltip" data-placement="top" title="Delete Category">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                            </svg>
                                        </button>
                                    </form>                   
                                </div>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- EDIT INPUT --}}
<div id="EditFormContainer" class="d-flex justify-content-center sticky-top w-100 h-100 position-absolute d-none">
    <div class="my-auto bg-light text-center w-75 w-50 ">
        <h1>Edit <span id="CategoryNameSpan"></span> category</h1>
        <div class="border p-1">
            <br>
            <form id="EditForm" method="post" action="">
                @csrf
                <div class="d-flex justify-content-center">
                    <input type="text" name="categoryName" id="CategoryNameEdit" placeholder="Name" class="input-group-text w-75">
                    <button type="submit"  class="btn btn-info">Save</button>
                    <a href="/categories" class="btn btn-danger">Back</a>
                </div>
            </form>    
        </div>
    </div>

</div>

<script>
    $('.EditCategory').off('click').on('click', function() {
        $('#CategoryNameEdit').attr('value', '')
        $('#MainPage').addClass('d-none');
        $('#EditFormContainer').removeClass('d-none');
        var category = $(this).attr('id')
        const categoryInfo = category.split(" ");
        var categoryKey = categoryInfo[0];
        var categoryId = categoryInfo[1];
        var categoryName = $(this).attr('categoryName')
        $('#EditForm').attr('action', '/categories/edit/'+categoryId)
        $('#CategoryNameSpan').text(categoryName)
        $('#CategoryNameEdit').attr('placeholder', categoryName)
    })

    $(document).on('click', "#DeleteBtn" , function (e){
        if (!confirm('This Category will be deleted.\n Are you Sure?')) {
            e.preventDefault();
        }
    })

    $('#CategoryForm').submit(function (e) { 
        if ($('#CategoryName').val() ==  "" ) {
            e.preventDefault();
        }
        
    });
</script>

@endsection