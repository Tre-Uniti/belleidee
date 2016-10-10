@extends('app')
@section('siteTitle')
    User Extensions
@stop

@section('centerText')
    <h2>Extensions by <a href={{ url('/users/'. $user->id)}}>{{ $user->handle }}</a></h2>
    <p>Filter by: Top <i class="fa fa-heart" aria-hidden="true"></i></p>
    <div class = "indexNav">
        <a href="{{ url('extensions/user/'. $user->id)}}" class = "indexLink">Recent</a>
        <a href="{{ url('/users/'.$user->id)}}" class = "indexLink">Profile</a>
        <a href="{{ url('extensions/user/extended/'. $user->id)}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <hr class = "contentSeparator">
    @foreach ($extensions as $extension)
        <div class = "contentExtensionCard">
            <div class = "cardTitleSection">
                <h3>
                    <a href="{{ action('ExtensionController@show', [$extension->id])}}">{{ $extension->title }}</a>
                </h3>

            </div>
            <div class = "cardHandleSection">
                <p>
                    By: <a href="{{ action('UserController@show', [$extension->user_id])}}" class = "contentHandle">{{ $extension->user->handle }}</a> on <a href = {{ url('/extensions/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a>
                </p>
                <p>
                    @if(isset($extension->extenception))
                        Extends: <a href = "{{ url('/extensions/' . $extension->extenception) }}">{{ $extension->extenceptionTitle($extension->extenception) }}</a>
                    @elseif(isset($extension->post_id))
                        Extends: <a href = "{{ url('/posts/' . $extension->post_id) }}">{{ $extension->post->title }}</a>
                    @elseif(isset($extension->question_id))
                        Answers: <a href = "{{ url('/questions/' . $extension->question_id) }}">{{ $extension->question->question }}</a>
                    @elseif(isset($extension->question_id))
                        Extends: <a href = "{{ url('/legacyPosts/' . $extension->legacy_post_id) }}">{{ $extension->legacyPost->title }}</a>
                    @endif
                </p>
            </div>
            <div class = "cardCaptionExcerptSection">
                <p class = "cardExcerpt">
                    {{ $extension->excerpt }}<a href="{{ action('ExtensionController@show', [$extension->id])}}">... Read More</a>
                </p>
            </div>

            <div class = "influenceSection">
                <div class = "elevationSection">
                    <div class = "elevationIcon">
                        @if($extension->elevateStatus === 'Elevated')
                            <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                        @else
                            <a href="{{ url('/extensions/elevate/'.$extension->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        @endif
                        <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                    </div>
                    <div class = "elevationCounter">
                        <a href={{ url('/extensions/listElevation/'.$extension->id)}}>{{ $extension->elevation }}</a>
                    </div>
                </div>

                <div class = "beaconSection">
                    <a href="{{ url('/beacons/'.$extension->beacon_tag) }}">{{ $extension->beacon_tag }}</a>
                    <span class="tooltiptext">Beacon community where this post is located</span>
                </div>

                <div class = "extensionSection">
                    <a href="{{ url('/extensions/extenception/'.$extension->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                    <a href={{ url('/extensions/extend/list/'.$extension->id)}}>{{ $extension->extension }}</a>
                    <span class="tooltiptext">Extend to add any inspiration you received</span>
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
@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
