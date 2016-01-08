@section('leftSideBar')
    <div>
        <h2><a href="{{ action('UserController@show', [$user->id])}}">{{$user->handle}}</a></h2>

        <div class = "innerPhotos">
            @if($photoPath === '')
                <a href="/"><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "97%" width = "85%"></a>
            @else
                <a href={{ url('/users/'. $user->id) }}><img src= {{ url('https://d3ekayvyzr0uoc.cloudfront.net'. $photoPath) }} alt="{{$user->handle}}" height = "97%" width = "85%"></a>
            @endif
        </div>
    </div>
@stop