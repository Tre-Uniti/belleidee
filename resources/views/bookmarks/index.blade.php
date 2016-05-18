@extends('app')
@section('siteTitle')
    Bookmarks
@stop

@section('centerText')

    <h2>Bookmarks of {{ $user->handle  }}</h2>
    <div class = "indexNav">
        <a href={{ url('/bookmarks/users')}}><button type = "button" class = "indexButton">Users</button></a>
        <a href={{ url('/bookmarks/beacons')}}><button type = "button" class = "indexButton">Beacons</button></a>
        <a href={{ url('/bookmarks/posts')}}><button type = "button" class = "indexButton">Posts</button></a>
        <a href={{ url('/bookmarks/extensions')}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Bookmark</h4>
    </div>
    <div class = "indexRight">
        <div class = "bookmarkLeft">
            <h4>Type</h4>
        </div>
        <div class = "bookmarkRight">
            <h4>Remove</h4>
        </div>
    </div>

        @foreach ($bookmarks as $bookmark)
            <div class = "listResource">
                <div class = "listResourceBookmarkLeft">
                    @if($bookmark['type'] === 'User')
                        <a href="{{ action('UserController@show', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButtonLeft">{{ $bookmark['title'] }}</button></a>
                    @elseif($bookmark['type'] === 'Beacon')
                        <a href="{{ action('BeaconController@listTagged', [$bookmark['pointer']])}}">
                           <button type = "button" class = "interactButtonLeft">{{ $bookmark['title'] }}</button></a>
                    @elseif($bookmark['type'] === 'Post')
                        <a href="{{ action('PostController@show', [$bookmark['pointer']])}}">
                             <button type = "button" class = "interactButtonLeft">{{ $bookmark['title'] }}</button></a>
                    @elseif($bookmark['type'] === 'Extension')
                        <a href="{{ action('ExtensionController@show', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButtonLeft">{{ $bookmark['title'] }}</button></a>
                    @endif
                </div>
                <div class = "listResourceRight">
                <div class = "listResourceBookmarkRight">
                    @if($bookmark['type'] === 'User')
                        <a href="{{ action('UserController@show', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButtonLeft">{{ $bookmark['type'] }}</button></a>
                    @elseif($bookmark['type'] === 'Beacon')
                        <a href="{{ action('BeaconController@listTagged', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButtonLeft">{{ $bookmark['type'] }}</button></a>
                    @elseif($bookmark['type'] === 'Post')
                        <a href="{{ action('PostController@show', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButtonLeft">{{ $bookmark['type'] }}</button></a>
                    @elseif($bookmark['type'] === 'Extension')
                        <a href="{{ action('ExtensionController@show', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButtonLeft">{{ $bookmark['type'] }}</button></a>
                    @endif

                </div>
                    <a href="{{ action('BookmarkController@remove', [$bookmark['id']])}}">
                        <button type = "button" class = "interactButton">/x\</button></a>

                </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $bookmarks->render() !!}
@stop


