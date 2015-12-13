@section('leftSideBar')
    <div>
        <h2><a href="{{ action('UserController@show', [$user->id])}}">{{$user->handle}}</a></h2>

        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>

    </div>
@stop