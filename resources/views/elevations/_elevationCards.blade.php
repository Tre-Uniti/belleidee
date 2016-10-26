@if(!count($elevations))
    <p>No Elevations <i class="fa fa-heart-o" aria-hidden="true"></i> yet!</p>
@else
@foreach ($elevations as $elevation)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>
                        <a href = "{{ url('/users/'. $elevation->user->id) }}">{{ $elevation->user->handle }}</a>
                    </h3>
                </header>
            </div>
            <div class = "footerSection">
                <div class = "leftIcon"><i class="fa fa-heart fa-lg" aria-hidden="true"></i></div> on {{ $elevation->created_at->format('M-d-Y') }}
            </div>
            <div class = "cardCaptionExcerptSection">
                <div class = "indexNav">
                    <div class = "cardImg">
                        @if($elevation->user->photo_path != NULL)
                            <a href={{ url('/users/'. $elevation->user->id) }}><img src= {{ url(env('IMAGE_LINK'). $elevation->user->photo_path) }} alt="{{$elevation->user->handle}}" height = "99%" width = "99%"></a>
                        @else
                            <a href={{ url('/users/'. $elevation->user->id) }}><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "99%" width = "99%"></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </article>
@endforeach
@endif