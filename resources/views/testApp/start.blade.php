@extends('layouts.app')

@section('content')
    
    <div
        id="Start-Screen"
        class="p-2 bg-white d-flex justify-content-center"
        style="min-height: 620px">
        <div class="my-auto ">
            <a id="Start-btn" href="/testApp/random" class="btn btn-lg btn-dark">START</a>
        </div>
    </div>
<script>
    $(document).ready(function () {
        localStorage.setItem('round', 0);
        localStorage.setItem('score', 0);
    })

</script>

@endsection