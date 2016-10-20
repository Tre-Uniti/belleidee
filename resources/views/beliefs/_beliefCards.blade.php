@foreach ($beliefs as $belief)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>
                        <a href = "{{ url('/beliefs/'. $belief->name) }}">{{$belief->name}}</a>
                    </h3>
                </header>
            </div>
            <div class = "cardPhoto">
            @if($belief->photo_path != NULL)
                <img src= {{ url(env('IMAGE_LINK'). $belief->photo_path) }} alt="{{$belief->name}}" height = "99%" width = "99%">
            @else
                <img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%">
            @endif
            </div>

            <div class = "cardCaptionExcerptSection">
                <p class = "cardExcerpt">
                    <a href = "{{ url('/beliefs/'. $belief->name) }}">{{$belief->description}}</a>
                </p>
                <p>
                    Latest Activity: {{ $belief->updated_at->format('M-d-Y') }}
                </p>
            </div>
            <div class = "indexNav">
                <a href="{{ url('/beliefs/posts/'. $belief->name) }}" class = "indexLink">Posts <div>{{ $belief->posts }}</div></a>
                <a href="{{ url('/beliefs/legacy/'. $belief->name) }}" class = "indexLink">Legacies <div>{{ $belief->legacy_posts }}</div></a>
                <a href="{{ url('/beliefs/beacons/'. $belief->name) }}" class = "indexLink">Beacons <div>{{ $belief->beacons }}</div></a>
            </div>
        </div>
    </article>
@endforeach