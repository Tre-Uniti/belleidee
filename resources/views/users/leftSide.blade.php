@section('leftSideBar')
    <div>
        <h2>{{$user->handle}}</h2>

        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>

    </div>
@stop