@extends('layouts.app')

@section('content')
<div class="container d-flex h-50 justify-content-center">
    <div class="card" style="height: 80vh; width: 100vw;">
        <div class="h-75 row justify-content-center">
            <img class="card-img-top h-100 w-75" src="/storage/{{ $games[$selected]->getRandomImage()['image_path'] }}" alt="">
        </div>
        <h6 class="text-center">Score : <span id="score"></span></h6>
        <div class="card-body">
            <div class="row">
                <div class="col text-center m-2">
                    <a id="0" class="card-text option-btn w-100 h-100 btn btn-dark">{{ $games[0]['name'] }}</a>
                </div>
                <div class="col text-center m-2">
                    <a id="1" class="card-text option-btn w-100 h-100 btn btn-dark">{{ $games[1]['name'] }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col text-center m-2">
                    <a id="2" class="card-text option-btn w-100 h-100 btn btn-dark">{{ $games[2]['name'] }}</a>
                </div>
                <div class="col text-center m-2">
                    <a id="3" class="card-text option-btn w-100 h-100 btn btn-dark">{{ $games[3]['name'] }}</a>
                </div>
            </div>
        </div>
    </div>
</div>    
<script type="application/javascript">
    var round = localStorage.getItem('round'); 
    var score = localStorage.getItem('score'); 
    var selected = {{ $selected }};

    $(document).ready(function () {
        $('#score').text(round)
    });

    $('.option-btn').on('click', function () {
        if ($(this).attr('id') == selected) {
            localStorage.setItem('round', parseInt(round)+1);
            localStorage.setItem('score', parseInt(score)+1 );
            location.reload();
        } else {
            window.location.replace('/testApp/lose')
        }
    });
</script>
@endsection