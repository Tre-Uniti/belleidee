@section('leftSideBar')
    <div>
        <h2><a href="{{ action('UserController@show', [$user->id])}}">{{$user->handle}}</a></h2>

        <div class = "innerPhotos">
            @if($photoPath === '')
                <a href="/"><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "97%" width = "85%"></a>
            @else
                <a href="/"><img src= {{ url('https://s3-us-west-2.amazonaws.com/'. $photoPath) }} alt="{{$user->handle}}" height = "97%" width = "85%"></a>
            @endif
        </div>

    </div>
@stop