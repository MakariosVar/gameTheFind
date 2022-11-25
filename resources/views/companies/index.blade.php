@extends('layouts.app')
@section('title', 'Companies')
@section('content')
<div class="w-100">
    <div id="MainPage" class="row justify-content-center">
        <h1 class="text-center">Companies</h1>
        <div class="text-center pb-2">
            <a href="/companies/create" class="btn btn-primary btn-sm">Add new Company</a>
        </div>
        <div class="col-md-8 border rounded p-2">
            <div class="border table-responsive">
                @if ($query)
                    <h3 class="text-center">Searching key: {{$query}}</h3>
                    <h6 class="text-center">
                        <a href="/companies">clear filter</a>
                    </h6>
                @endif
                <div class="d-flex justify-content-center">
                    <form action="/companies/search" method="post">
                        @csrf
                        <div class="input-group input-group-sm m-2">
                            <input type="text" name="companyQuery" class="form-control" placeholder="Search...">
                            <button type="submit" class="btn btn-warning">Search</button>
                        </div>
                    </form>
                </div>
                <table class="table table-striped border">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="text-center">Logo</th>
                            <th scope="col" class="w-75 text-center">Name</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($companies) === 0) 
                                <h6 class="text-center">No Results</h6> 
                        @endif
                        @foreach ($companies as $key => $company)
                        <tr>
                            <th scope="row">{{ $key+1 }}</th>
                            <th scope="row">
                                @if ($company['logo'])   
                                    <img 
                                        src="/storage/{{ $company['logo'][0]['image_path'] }}" 
                                        alt="ela"
                                        class="logo-company-grid"
                                        >
                                @endif
                            </th>

                            <td class="company-name-column">
                                <a href="/companies/view/{{ $company->id }}" class="text-decoration-none text-dark">
                                    <h4 class="h5 w-100 text-center mb-3">
                                        <span id="CompanyNameLink">
                                            {{ $company['name'] }}
                                        </span>
                                    </h4>
                                </a>
                            </td>
                            
                            <td>
                                <div class="d-flex justify-content-end">
                                    {{-- VIEW BUTTON --}}
                                    <form action="/companies/view/{{ $company['id'] }}" method="get">
                                        <button class="EditCompany btn text-dark text-decoration-none" data-toggle="tooltip" data-placement="top" title="View Company">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>   
                                    </form>
                                    {{-- EDIT BUTTON --}}
                                    <form action="/companies/edit/{{ $company['id'] }}" method="get">
                                        <button class="EditCompany btn text-primary text-decoration-none" data-toggle="tooltip" data-placement="top" title="Edit Company">
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
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
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
