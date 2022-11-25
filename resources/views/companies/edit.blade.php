@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <u>
                        Edit {{ $company->name }}
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
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="card-body text-center col d-flex justify-content-center ">
                    <form action="/companies/update/{{ $company->id }}" method="post" class="w-75" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden"  name="id" value="{{ $company->id }}">
                        <div class="form-group">
                            <label for="companyName">Company name:</label>
                            <input type="text" placeholder="{{ $company->name }}" class="form-control text-center" name="companyName">
                        </div>
                        <div class="col-lg-6 mx-auto p-2">

                            <!-- Upload image input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload" type="file" name="companyLogo" onchange="readURL(this);" class="form-control border-0">
                                <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose Image</label>
                                <div class="input-group-append">
                                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                                </div>
                            </div>
                            <!-- Uploaded image area-->
                            @if(!empty($company->logo[0]))
                                <div class="image-area"><img id="imageResult" src="/storage/{{ $company->logo[0]['image_path'] }}" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                            @else
                                <div class="image-area"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                            @endif
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" @if($company->hasNameOnLogo) checked @endif name="hasNameOnLogo"> Image contains the company name</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /*  ==========================================
    SHOW UPLOADED IMAGE
* ========================================== */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(function () {
    $('#upload').on('change', function () {
        readURL(input);
    });
});

/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */
var input = document.getElementById( 'upload' );
var infoArea = document.getElementById( 'upload-label' );

input.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var fileName = input.files[0].name;
    var input = event.srcElement;
    infoArea.textContent = 'File name: ' + fileName;
}
</script>
@endsection
