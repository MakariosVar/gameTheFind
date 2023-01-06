@extends('layouts.app')
@section('title', 'Add Game')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><u>Add new game</u></div>
                <a href="/games" class="text-decoration-none text-dark">
                    <div class="d-flex mt-2 justify-content-center">
                        <p class="text-center">All games</p>
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
                    <form action="/games/store" method="post" class="w-75" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="gameName">Game name:</label>
                            <input type="text" placeholder="name..." class="form-control text-center" name="gameName" value="{{ old('gameName') }}">
                        </div>
                        {{-- CATEGORY --}}
                        <div id="Category" class="mt-3">
                            <label for="category">Select Category</label>
                            <select class="categorySelect2 from-control" name="category" value="{{ old('category') }}" multiple="multiple>
                                @foreach($categories as $category)
                                    @if ( old('category') == $category['id'])
                                        <option selected value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @else    
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endif
                                @endforeach
                                </select>
                        </div>
                        {{-- TAGS --}}
                        <div id="Tags" class="mt-3">
                            <label for="tags[]">Select Tags</label>
                            <select class="tagsSelect2 from-control w-75" name="tags[]"  multiple="multiple">
                                @foreach($tags as $tag)
                                    @if ( old('tags') && in_array($tag->id, old('tags')))
                                        <option selected value="{{ $tag->id }}">{{ $tag->name }}</option>                                    
                                    @else
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endif
                                @endforeach
                                </select>
                        </div>
                        <hr>
                        {{-- Companies --}}
                        <div id="Companies" class="mt-3 d-flex flex-row-reverse align-items-center">
                            <label for="companies[]">Select Companies</label>
                            <select class="tagsSelect2 from-control w-75" name="companies[]"  multiple="multiple">
                                @foreach($companies as $company)
                                    @if ( old('companies') && in_array($company->id, old('companies')) )
                                        <option selected value="{{ $company->id }}">{{ $company->name }}</option>
                                    @else
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endif
                                @endforeach
                                </select>
                        </div>
                        {{-- RELEASH DATE --}}
                        <div id="ReleashDate" class="mt-3">
                            <label for="release_date">Releash Date:</label>
                            <input type="date" id="release_date" name="release_date" value="{{ old('release_date')}}">
                            <div class="col-lg-6 mx-auto p-2">
                        </div>
                        <div class="checkbox mb-2">
                            <label><input type="checkbox" name="is2D" {{ old('is2D') == "on" ? 'checked' : '' }} > Game is 2D</label>
                        </div>
                        <div id="image1" class="border rounded">
                            <!-- Upload image 1 input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload1" type="file" name="gameImage1" onchange="readURL1(this);" class="form-control border-0" value="{{ old('gameImage1') }}">
                                <label id="upload-label1" for="upload" class="font-weight-light text-muted">Choose Image</label>
                                <div class="input-group-append">
                                    <label for="upload1" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                                </div>
                            </div>
                            
                            <!-- Uploaded image 1 area-->
                            <div class="image-area">
                                <img id="imageResult1" src="#" alt="" class="img-fluid w-50 rounded shadow-sm mx-auto d-block">
                            </div>
                        </div>    
                        <div id="image2" class="border rounded">
                            <!-- Upload image 2 input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload2" type="file" name="gameImage2" onchange="readURL2(this);" class="form-control border-0">
                                <label id="upload-label2" for="upload" class="font-weight-light text-muted">Choose Image</label>
                                <div class="input-group-append">
                                    <label for="upload2" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                                </div>
                            </div>
                            
                            <!-- Uploaded image 2 area-->
                            <div class="image-area">
                                <img id="imageResult2" src="3" alt="" class="img-fluid w-50 rounded shadow-sm mx-auto d-block">
                            </div>
                        </div>   
                
                        <div id="image3" class="border rounded">
                            <!-- Upload image 3 input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload3" type="file" name="gameImage3" onchange="readURL3(this);" class="form-control border-0">
                                <label id="upload-label3" for="upload" class="font-weight-light text-muted">Choose Image</label>
                                <div class="input-group-append">
                                    <label for="upload3" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                                </div>
                            </div>
                
                            <!-- Uploaded image 3 area-->
                            <div class="image-area">
                                <img id="imageResult3" src="#" alt="" class="img-fluid w-50 rounded shadow-sm mx-auto d-block">
                            </div>
                        </div>
                        <div id="image4" class="border rounded">
                            <!-- Upload image 4 input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload4" type="file" name="gameImage4" onchange="readURL4(this);" class="form-control border-0">
                                <label id="upload-label4" for="upload" class="font-weight-light text-muted">Choose Image</label>
                                <div class="input-group-append">
                                    <label for="upload4" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                                </div>
                            </div>
                            <!-- Uploaded image 4 area-->
                            <div class="image-area">
                                <img id="imageResult4" src="#" alt="" class="img-fluid w-50 rounded shadow-sm mx-auto d-block">
                            </div>
                        </div>
                        
                        <div id="image5" class="border rounded"></div>
                            <!-- Upload image 5 input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload5" type="file" name="gameImage5" onchange="readURL5(this);" class="form-control border-0">
                                <label id="upload-label5" for="upload" class="font-weight-light text-muted">Choose Image</label>
                                <div class="input-group-append">
                                    <label for="upload5" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Browse...</small></label>
                                </div>
                            </div>
                
                            <!-- Uploaded image 5 area-->
                            <div class="image-area">
                                <img id="imageResult5" src="#" alt="" class="img-fluid w-50 rounded shadow-sm mx-auto d-block">
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
    /*  ==========================================
    SHOW UPLOADED IMAGE 
* ========================================== */

// ```           1       ```
function readURL1(input1) {
    if (input1.files && input1.files[0]) {
        var reader1 = new FileReader();

        reader1.onload = function (e) {
            $('#imageResult1')
                .attr('src', e.target.result);
        };
        reader1.readAsDataURL(input1.files[0]);
    }
}

$(function () {
    $('#upload1').on('change', function () {
        readURL1(input1);
    });
});

// ```           2       ```
function readURL2(input2) {
    if (input2.files && input2.files[0]) {
        var reader2 = new FileReader();

        reader2.onload = function (e) {
            $('#imageResult2')
                .attr('src', e.target.result);
        };
        reader2.readAsDataURL(input2.files[0]);
    }
}

$(function () {
    $('#upload2').on('change', function () {
        readURL2(input2);
    });
});

// ```           3       ```
function readURL3(input3) {
    if (input3.files && input3.files[0]) {
        var reader3 = new FileReader();

        reader3.onload = function (e) {
            $('#imageResult3')
                .attr('src', e.target.result);
        };
        reader3.readAsDataURL(input3.files[0]);
    }
}

$(function () {
    $('#upload3').on('change', function () {
        readURL3(input3);
    });
});

// ```           4       ```
function readURL4(input4) {
    if (input4.files && input4.files[0]) {
        var reader4 = new FileReader();

        reader4.onload = function (e) {
            $('#imageResult4')
                .attr('src', e.target.result);
        };
        reader4.readAsDataURL(input4.files[0]);
    }
}

$(function () {
    $('#upload4').on('change', function () {
        readURL4(input4);
    });
});

// ```           5       ```
function readURL5(input5) {
    if (input5.files && input5.files[0]) {
        var reader5 = new FileReader();

        reader5.onload = function (e) {
            $('#imageResult5')
                .attr('src', e.target.result);
        };
        reader5.readAsDataURL(input5.files[0]);
    }
}

$(function () {
    $('#upload5').on('change', function () {
        readURL5(input5);
    });
});

/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */

// ``````````      1    `````````

var input1 = document.getElementById( 'upload1' );
var infoArea1 = document.getElementById( 'upload-label1' );

input1.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var fileName1 = input1.files[0].name;
    var input1 = event.srcElement;
    infoArea1.textContent = 'File name: ' + fileName;
}

// ``````````      2    `````````

var input2 = document.getElementById( 'upload2' );
var infoArea2 = document.getElementById( 'upload-label2' );

input2.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var fileName2 = input2.files[0].name;
    var input2 = event.srcElement;
    infoArea2.textContent = 'File name: ' + fileName;
}

// ``````````      3    `````````

var input3 = document.getElementById( 'upload3' );
var infoArea3 = document.getElementById( 'upload-label3' );

input3.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var fileName3 = input3.files[0].name;
    var input3 = event.srcElement;
    infoArea3.textContent = 'File name: ' + fileName;
}

// ``````````      4    `````````

var input4 = document.getElementById( 'upload4' );
var infoArea4 = document.getElementById( 'upload-label4' );

input4.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var fileName4 = input4.files[0].name;
    var input4 = event.srcElement;
    infoArea4.textContent = 'File name: ' + fileName;
}

// ``````````      5    `````````

var input5 = document.getElementById( 'upload5' );
var infoArea5 = document.getElementById( 'upload-label5' );

input5.addEventListener( 'change', showFileName );
function showFileName( event ) {
    var fileName5 = input5.files[0].name;
    var input5 = event.srcElement;
    infoArea5.textContent = 'File name: ' + fileName;
}

$(document).ready(function() {
    $('.tagsSelect2').select2();
});


$(document).ready(function() {
    $('.categorySelect2').select2({
		 maximumSelectionLength: 1
	});
});
</script>
@endsection
