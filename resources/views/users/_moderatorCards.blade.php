@if(!count($moderators))
    <p>No moderators to show.</p>
@endif
@foreach ($moderators as $moderator)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>
                        <a href = "{{ url('/users/'. $moderator->user->id) }}">{{$moderator->user->handle}}</a>
                    </h3>
                </header>
            </div>

            <div class = "indexNav">
                <div class = "cardImg">
                    @if($moderator->user->photo_path != NULL)
                        <a href={{ url('/users/'. $moderator->user->id) }}><img src= {{ url(env('IMAGE_LINK'). $moderator->user->photo_path) }} alt="{{$moderator->user->handle}}" height = "99%" width = "99%"></a>
                    @else
                        <a href={{ url('/users/'. $moderator->user->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                    @endif
                </div>
            </div>
            <p>
                {!! Form::open(['method' => 'DELETE', 'route' => ['removeModerator', $moderator->id], 'class' => 'formDeletion']) !!}
                {!! Form::submit('Remove', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
            </p>
            <div class = "cardHandleSection">
                <p>
                    Latest Activity: {{ $moderator->user->updated_at->format('M-d-Y') }}
                </p>
            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <a href="{{ url('/users/elevatedBy/'. $moderator->user->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Total elevation (hearts) of user content</span>
                        </div>
                    <div class = "leftCounter">
                        <a href="{{ url('/users/elevatedBy/'. $moderator->user->id) }}">{{ $moderator->user->elevation }}</a>
                    </div>
                </div>
                <div class = "centerSection">
                    <a href="{{ url('/beacons/'.$moderator->beacon->beacon_tag) }}" >{{ $moderator->beacon->beacon_tag }}</a>
                    <span class="tooltiptext">Beacon community where this user is a moderator</span>
                </div>
                <div class = "rightSection">
                    <div class = "rightIcon">
                        <a href="{{ url('/users/extendedBy/'. $moderator->user->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                        <span class="tooltiptext">Total extension of user content</span>
                    </div>
                        <div class = "rightCounter">
                            <a href="{{ url('/users/extendedBy/'. $moderator->user->id) }}">{{ $moderator->user->extension }}</a>
                        </div>
                    </div>
                </div>
            </div>
    </article>
@endforeach