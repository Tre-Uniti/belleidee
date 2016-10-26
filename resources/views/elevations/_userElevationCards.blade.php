

@if(!count($elevations))
    <p>No Elevations <i class="fa fa-heart-o" aria-hidden="true"></i> yet!</p>
@else
    @foreach ($elevations as $elevation)
        <article>
            <div class = "contentCard">
                    <div class = "cardTitleSection">
                        <h4>
                            @if (isset($elevation->post_id))
                                <a href="{{ action('PostController@show', [$elevation->post_id])}}">{{ $elevation->post->title }}</a>
                            @elseif (isset($elevation->extension_id))
                                <a href="{{ action('ExtensionController@show', [$elevation->extension_id])}}">{{ $elevation->extension->title }}</a>
                            @elseif (isset($elevation->question_id))
                                <a href="{{ action('QuestionController@show', [$elevation->question_id])}}">{{ $elevation->question->question }}</a>
                            @elseif (isset($elevation->legacy_post_id))
                                <a href="{{ action('LegacyPostController@show', [$elevation->legacy_post_id])}}">{{ $elevation->legacyPost->title }}</a>
                            @endif
                        </h4>
                        <div class = "footerSection">
                            <div class = "leftIcon"><i class="fa fa-heart fa-lg" aria-hidden="true"></i></div> by
                            <a href = "{{ url('/users/'. $elevation->user->id) }}">{{ $elevation->user->handle }}</a> on {{ $elevation->created_at->format('M-d-Y') }}
                        </div>
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