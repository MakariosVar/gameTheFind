@extends('layouts.app')
@section('title', 'Add Company')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><u>Add new company</u></div>
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
                    <form action="/companies/store" method="post" class="w-75" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="companyName">Company name:</label>
                            <input type="text" placeholder="name..." class="form-control text-center" name="companyName">
                        </div>
                        <div class="col-lg-6 mx-auto p-2">

                        <!-- Upload image 1input-->
                        <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                            <input id="upload1" type="file" name="companyLogo" onchange="readURL1(this);" class="form-control border-0">
                            <label id="upload-label1" for="upload" class="font-weight-light text-muted">Choose Image</label>
                            <div class="input-group-append">
                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                            </div>
                        </div>
                        <!-- Uploaded image area-->
                            <div class="image-area"><img id="imageResult1" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                        </div>
                        <div class="checkbox">
                            <label><input id="hasNameOnLogo" type="checkbox" name="hasNameOnLogo"> Image contains the company name</label>
                        </div>
                        <div id="Unamed" class="d-none">
                            <h3><u>Logo without Name</u></h3>
                            <div class="col-lg-8 mx-auto p-2 rounded">
                                <!-- Upload image 2input-->
                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                    <input id="upload2" type="file" name="companyLogoUnamed" onchange="readURL2(this);" class="form-control border-0">
                                    <label id="upload-label2" for="upload2" class="font-weight-light text-muted">Choose Image</label>
                                    <div class="input-group-append">
                                        <label for="upload2" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                                    </div>
                                </div>
                                <!-- Uploaded image area-->
                                    <div class="image-area"><img id="imageResult2" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document)
        .off('click', '#hasNameOnLogo')
        .on('click', '#hasNameOnLogo', function () {
            if ($(this).is(':checked')) {
                $('#Unamed').removeClass('d-none')
            } else {
                $('#Unamed').addClass('d-none')
            }
        })

        function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult1')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult2')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(function () {
    $('#upload1').on('change', function () {
        readURL1(input1);
    });
    $('#upload2').on('change', function () {
        readURL2(input2);
    });
});

/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */
var input1 = document.getElementById( 'upload1' );
var infoArea1 = document.getElementById( 'upload-label1' );
var input2 = document.getElementById( 'upload2' );
var infoArea2 = document.getElementById( 'upload-label2' );

input1.addEventListener( 'change', showFileName1 );
input2.addEventListener( 'change', showFileName2);
function showFileName1( event ) {
    var fileName = input1.files[0].name;
    var input = event.srcElement;
    infoArea1.textContent = 'File name: ' + fileName;
}
function showFileName2( event ) {
    var fileName = input2.files[0].name;
    var input = event.srcElement;
    infoArea2.textContent = 'File name: ' + fileName;
}
</script>
@endsection
