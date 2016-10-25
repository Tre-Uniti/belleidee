@if(count($extensions) == 0)
    <p>No extensions yet!</p>
@else
@foreach ($extensions as $extension)
    <div class = "contentExtensionCard">
        <div class = "cardTitleSection">
            <h4>
                @if(isset($extension->extenception))
                    <a href = "{{ url('/extensions/'. $extension->id) }}">Extends:</a> <a href="{{ action('ExtensionController@show', [$extension->extenception])}}"> another Extension</a>
                @elseif(isset($extension->post_id))
                    <a href = "{{ url('/extensions/'. $extension->id) }}">Extends:</a> <a href="{{ url('posts/' . $extension->post_id)}}">{{ $extension->post->title }}</a>
                @elseif(isset($extension->question_id))
                    <a href = "{{ url('/extensions/'. $extension->id) }}">Answers:</a> <a href="{{ url('/questions/'. $extension->question_id) }}">{{ $extension->question->question }}</a>
                @elseif(isset($extension->legacy_post_id))
                    <a href = "{{ url('/extensions/'. $extension->id) }}">Extends:</a> <a href="{{ url('/legacyPosts/'. $extension->legacy_post_id) }}">{{ $extension->legacyPost->title }}</a>
                @endif
            </h4>
            <div class = "cardHandleSection">
                <p>
                    By: <a href="{{ action('UserController@show', [$extension->user_id])}}" class = "contentHandle">{{ $extension->user->handle }}</a> on <a href = {{ url('$/extensions/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a>
                </p>
            </div>
        </div>
        <div class = "cardCaptionExcerptSection">
            <p class = "cardExcerpt">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}">{{ $extension->excerpt }}</a><a href="{{ action('ExtensionController@show', [$extension->id])}}">... Read More</a>
            </p>
        </div>
        <div class = "footerSection">
            <div class = "leftSection">
                <div class = "leftIcon">
                    @if($extension->elevationStatus === 'Elevated')
                        <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                    @else
                        <a href="{{ url('/extensions/elevate/'.$extension->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                    @endif
                    <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                </div>
                <div class = "leftCounter">
                    <a href={{ url('/extensions/listElevation/'.$extension->id)}}>{{ $extension->elevation }}</a>
                </div>
            </div>

            <div class = "centerSection">
                <a href="{{ url('/beacons/'.$extension->beacon_tag) }}">{{ $extension->beacon_tag }}</a>
                <span class="tooltiptext">Beacon community where this extension is located</span>
            </div>

            <div class = "rightSection">
                <div class = "rightIcon">
                    <a href="{{ url('/extensions/extenception/'.$extension->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                    <span class="tooltiptext">Extend to add any inspiration you received</span>
                </div>
                <div class = "rightCounter">
                    <a href={{ url('/extensions/extend/list/'.$extension->id)}}>{{ $extension->extension }}</a>
                </div>
            </div>
            <div class = "moreSection">
                <p class = "moreOptions"><i class="fa fa-angle-up fa-lg" aria-hidden="true"></i></p>
                <div class="moreOptionsMenu">
                    <a href="{{ url('bookmarks/extensions/'.$extension->id) }}"><i class="fa fa-bookmark-o fa-lg" aria-hidden="true"></i></a>
                    <a href="https://www.facebook.com/share.php?u={{Request::url()}}&title={{$extension->title}}" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/intent/tweet?status={{$extension->title}} - {{Request::url()}}" target="_blank"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a>
                    <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>
                    @if($extension->user_id != Auth::id())
                        <a href="{{ url('/intolerances/extension/'.$extension->id) }}"><i class="fa fa-flag-o fa-lg" aria-hidden="true"></i></a>
                    @elseif ($extension->status < 1)
                        Status: Tolerant
                    @else
                        Status: Intolerant
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
@endif