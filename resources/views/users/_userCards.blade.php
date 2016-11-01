@if(!count($users))
    <p>No users to show.</p>
@endif
@foreach ($users as $User)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>
                        <a href = "{{ url('/users/'. $User->id) }}">{{$User->handle}}</a>
                    </h3>
                </header>
            </div>

            <div class = "indexNav">
                <div class = "cardImg">
                    @if($User->photo_path != NULL)
                        <a href={{ url('/users/'. $User->id) }}><img src= {{ url(env('IMAGE_LINK'). $User->photo_path) }} alt="{{$User->handle}}" height = "99%" width = "99%"></a>
                    @else
                        <a href={{ url('/users/'. $User->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                    @endif
                </div>
            </div>
            <div class = "cardHandleSection">
                <p>
                    Latest Activity: {{ $User->updated_at->format('M-d-Y') }}
                </p>
            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <a href="{{ url('/users/elevatedBy/'. $User->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Total elevation (hearts) of user content</span>
                        </div>
                    <div class = "leftCounter">
                        <a href="{{ url('/users/elevatedBy/'. $User->id) }}">{{ $User->elevation }}</a>
                    </div>
                </div>
                <div class = "centerSection">
                    <a href="{{ url('/beacons/'.$User->last_tag) }}" >{{ $User->last_tag }}</a>
                    <span class="tooltiptext">Beacon community where this user is located</span>
                </div>
                <div class = "rightSection">
                    <div class = "rightIcon">
                        <a href="{{ url('/users/extendedBy/'. $User->id) }}" class = "iconLink" > <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
                        <span class="tooltiptext">Total extension of user content</span>
                    </div>
                        <div class = "rightCounter">
                            <a href="{{ url('/users/extendedBy/'. $User->id) }}">{{ $User->extension }}</a>
                        </div>
                    </div>
                </div>
            </div>
    </article>
@endforeach