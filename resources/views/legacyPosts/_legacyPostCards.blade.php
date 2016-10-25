@if(!count($legacyPosts))
    <p>No Legacy Posts yet!</p>
    @else
@foreach ($legacyPosts as $legacyPost)
    <article>
        <div class = "contentCard">
            <header>
                <div class = "cardTitleSection">
                    <h3>
                        <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}">{{ $legacyPost->title }}</a>
                    </h3>
                </div>
                <div class = "cardHandleSection">
                    <p>
                        Created on <a href = {{ url('/legacyPosts/date/'.$legacyPost->created_at->format('M-d-Y')) }}>{{ $legacyPost->created_at->format('M-d-Y') }}</a>
                    </p>
                </div>
            </header>
            <div class = "cardCaptionExcerptSection">
                <p class = "cardExcerpt">
                    <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}" class = "excerptText">{{ $legacyPost->excerpt }}</a>
                    <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}">... Read More</a>
                </p>

            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        @if($legacyPost->elevationStatus === 'Elevated')
                            <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                        @else
                            <a href="{{ url('/legacyPosts/elevate/'.$legacyPost->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        @endif
                        <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                    </div>

                    <div class = "leftCounter">
                        <a href={{ url('/legacyPosts/list/elevation/'.$legacyPost->id)}}>{{ $legacyPost->elevation }}</a>
                    </div>

                </div>

                <div class = "centerSection">
                    <a href="{{ url('/beliefs/'.$legacyPost->belief) }}" >{{ $legacyPost->belief }}</a>
                    <span class="tooltiptext">Belief or way of life this Legacy relates to</span>
                </div>

                <div class = "rightSection">
                    <div class = "rightIcon">
                        <a href="{{ url('/extensions/legacy/'.$legacyPost->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Extend to add any inspiration you received</span>
                    </div>
                    <div class = "rightCounter">
                        <a href={{ url('/legacyPosts/list/extension/'.$legacyPost->id)}}>{{ $legacyPost->extension }}</a>

                    </div>
                </div>

            </div>
        </div>
    </article>
@endforeach
    @endif