@extends('layouts.app')

@section('content')
    <div
    id="Start-Screen"
    class="p-2 bg-danger d-flex justify-content-center"
    style="min-height: 620px">
    <div class="my-auto text-center">
            <h1>ΕΧΑΣΕΣ</h1>
            <p class="h4">Score <span id="score"></span></p>
            <a id="Start-btn" href="#" class="btn btn-lg btn-dark">RESTART</a>
        </div>
    </div>
<script>
    $(document).ready(function () {
        var round = localStorage.getItem('round'); 
        var score = localStorage.getItem('score'); 

        $('#score').text(score)
    })
    $('#Start-btn').on('click', function () {
        localStorage.setItem('round', 0);
        localStorage.setItem('score', 0 );
        window.location.replace('/testApp/random')
    })
</script>

@endsection