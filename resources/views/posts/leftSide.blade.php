@section('leftSideBar')
    <div id = "leftSide">
        <div class = "innerProfileMenus">
            <h2>{{$user->handle}}</h2>
            <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>
            <p>This is your motto, it is customized by the user
                It can be your motto, or another motto you like.  What happens with a third line</p>
        </div>
        <hr/>
        <div class = "innerProfileMenus">
            <h2>Your Posts</h2>
            <ul>
                @if ($profilePosts->isEmpty())
                    <li><a href="{{url('/post/create')}}"> <button type = "button" class = "interactButton">Create a new Post</button></a></li>
                @else
                    @foreach($profilePosts as $profilePost)
                        <li><a href="{{ action('PostController@show', [$profilePost->id])}}"> <button type = "button" class = "interactButton">{{ $profilePost->title }}</button></a></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <hr/>
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>
    </div>
@stop