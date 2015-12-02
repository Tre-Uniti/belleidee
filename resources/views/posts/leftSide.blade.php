@section('leftSideBar')
    <div>
        <h2>{{$user->handle}}</h2>

        <nav>
            <ul>
                @if ($profilePosts->isEmpty())
                    <li><a href="{{url('/post/create')}}">Posts</a></li>
                @else
                    <li>
                        <a href="{{ action('PostController@show', [$profilePosts[0]->id])}}">{{ $profilePosts[0]->created_at->format('M-d-Y') }}</a>
                        <div>
                            <ul>
                                @foreach($profilePosts as $profilePost)
                                    <li><a href={{ action('PostController@show', [$profilePost->id])}}>{{ $profilePost->created_at->format('M-d-Y')}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
                    @if ($profileExtensions->isEmpty())
                        <li><a href="{{url('/posts')}}">Extend</a></li>
                    @else
                        <li>
                            <a href="{{ url('/posts') }}">Extends</a>
                            <div>
                                <ul>
                                    @foreach($profileExtensions as $profileExtension)
                                        <li><a href={{ action('ExtensionController@show', [$profileExtension->id])}}>{{ $profileExtension->created_at->format('M-d-Y')}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
            </ul>
        </nav>

        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>

    </div>
@stop