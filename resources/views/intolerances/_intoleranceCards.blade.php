@if(count($intolerances) == 0)
    <p>No intolerance reports at the moment!</p>
@else
    @foreach ($intolerances as $intolerance)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            @if($intolerance->post_id != null)
                                 <a href="{{ action('PostController@show', [$intolerance->post_id])}}" target = "_blank">Post {{ $intolerance->post_id }}</a>
                            @elseif($intolerance->extension_id != null)
                                <a href="{{ action('ExtensionController@show', [$intolerance->extension_id])}}" target = "_blank">Extension {{ $intolerance->extension_id }}</a>
                            @endif
                                By: <a href="{{ action('UserController@show', [$intolerance->source_user])}}">{{ $intolerance->source_user}}</a>
                        </h3>
                        <p>Beacon: <a href="{{ url('/beacons/' . $intolerance->beacon_tag) }}">{{ $intolerance->beacon_tag }}</a></p>
                    </header>
                </div>
                <div class = "cardHandleSection">
                    @if($intolerance->user_id == Auth::id())
                        <a href="{{ url('/intolerances/'.$intolerance->id.'/edit') }}" class = "navLink">Edit</a>
                    @elseif($user->type > 0)
                        <a href="{{ url('/moderations/intolerance/'. $intolerance->id) }}" class = "navLink">Moderate</a>
                    @endif
                    <p class = "contentHandle">
                        <a href = "{{ action('IntoleranceController@show', [$intolerance->id])}}">Content contains: {{ $intolerance->user_ruling }}</a>
                    </p>
                    <p>
                        Submitted by: <a href="{{ action('UserController@show', [$intolerance->user_id])}}">{{ $intolerance->user->handle}}</a>
                        on <a href = "{{ action('IntoleranceController@show', [$intolerance->id])}}">{{ $intolerance->created_at->format('M-d-Y')}}</a>
                    </p>
                </div>
            </div>
        </article>
    @endforeach
@endif