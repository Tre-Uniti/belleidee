@foreach ($sponsors as $sponsor)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>
                        <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->name}}</a>
                    </h3>

                </header>
            </div>

            <div class = "indexNav">
                <div class = "cardImg">
                    @if($sponsor->photo_path != NULL)
                        <a href={{ url('/sponsors/'. $sponsor->sponsor_tag) }}><img src= {{ url(env('IMAGE_LINK'). $sponsor->photo_path) }} alt="{{$sponsor->name}}" height = "99%" width = "99%"></a>
                    @else
                        <a href={{ url('/sponsors/'. $sponsor->sponsor_tag) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                    @endif
                </div>
            </div>
            <div class = "cardHandleSection">
                <p>
                    <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{$sponsor->sponsor_tag}}</a>
                </p>
            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        <span class="tooltiptext">Number of monthly clicks for {{ $sponsor->sponsor_tag }}</span>
                        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></a>
                        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->clicks }}</a>
                    </div>
                </div>
                <div class = "centerSection">
                    <a href="{{ url('/sponsors/sponsorships' . $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                    <a href = "{{ url('/sponsors/sponsorships'. $sponsor->sponsor_tag) }}">{{ $sponsor->sponsorships }}</a>
                    <span class="tooltiptext">Number of sponsored users</span>
                </div>
                <div class = "rightSection">
                    <div class = "rightIcon">
                        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "iconLink"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Number of monthly views</span>
                    </div>
                    <div class = "rightCounter">
                        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->views }}</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endforeach