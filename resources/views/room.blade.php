<link rel="stylesheet" href="/css/app.css">
    <div class="container" id="app" >

        <room :room="{{$room}}" :user="{{Auth::user()}} "  :lastt="{{ $lastPage }}" ></room>
    </div>

    <script src="/js/app.js"></script>
