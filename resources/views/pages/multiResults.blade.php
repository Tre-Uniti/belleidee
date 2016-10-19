@extends('app')
@section('siteTitle')
    Global Results
@stop

@section('centerText')
        <h2>Search Results for '{{$identifier}}'</h2>
        <p>Location scope: {{ $location }}</p>
        <p>Filter by:</p>
        <a href="{{ url('/users/results?identifier=' . $identifier) }}" class = "indexLink">Users: {{ $userCount }}@if($userCount == 10)+ @endif </a>
        <a href="{{ url('/beacons/results?identifier=' . $identifier) }}" class = "indexLink">Beacons: {{ $beaconCount}}@if($beaconCount == 10)+ @endif</a>
        <a href="{{ url('/sponsors/results?identifier=' . $identifier) }}" class = "indexLink">Sponsors: {{ $sponsorCount }}@if($sponsorCount == 10)+ @endif</a>
        <a href="{{ url('/posts/results?identifier=' . $identifier) }}" class = "indexLink">Posts: {{ $postCount }}@if($postCount == 10)+ @endif</a>
        <a href="{{ url('/legacyPosts/results?identifier=' . $identifier) }}" class = "indexLink">Legacies: {{ $legacyCount }}@if($legacyCount == 10)+ @endif</a>
        <a href="{{ url('/extensions/results?identifier=' . $identifier) }}" class = "indexLink">Extensions: {{ $extensionCount }}@if($extensionCount == 10)+ @endif</a>


        <div class = "contentHeaderSeparator">
            <h3>User Results</h3>
        </div>
        @if($userCount == 0)
            <p>0 users with this handle</p>
        @else
            @include('users._userCards')
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Beacon Results</h3>
        </div>
        @if($beaconCount == 0)
            <p>0 beacons with this name or tag</p>
        @else
            @include('beacons._beaconCards')
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Sponsors Results</h3>
        </div>
        @if($sponsorCount == 0)
            <p>0 sponsors with this name or tag</p>
        @else
           @include('sponsors._sponsorCards')
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Post Results</h3>
        </div>
        @if($postCount == 0)
            <p>0 posts with this title</p>
        @else
            @include('posts._postCards')
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Legacy Results</h3>
        </div>
        @if($legacyCount == 0)
            <p>0 legacy posts with this title</p>
        @else
          @include('legacyPosts._legacyPostCards')
        @endif

        <div class = "contentHeaderSeparator">
            <h3>Extension Results</h3>
        </div>
        @if($extensionCount == 0)
            <p>0 extensions with this title</p>
        @else
            @include('extensions._extensionCards')
    @endif

@stop




