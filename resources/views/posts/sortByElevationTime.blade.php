@extends('app')
@section('siteTitle')
    Elevated Posts
@stop

@section('centerText')
    <h2>Top Posts ({{ $filter }})</h2>
        <div class = "indexNav">
            <a href="{{ url('/posts')}}" class = "indexLink">Recent</a>
            <a href="{{ url('/posts/forYou')}}" class = "indexLink">For You</a>
            @if($user->last_tag != null)
                <a href="{{ url('/beacons/posts/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
            @endif
            <a href="{{ url('posts/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
<p>Sort by <i class="fa fa-heart" aria-hidden="true"></i></p>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = "{{ url('posts/elevationTime/Today') }}" @if($time == 'Today')class = "navLink" @else class = "indexLink" @endif>Today</a>
                    <a href = "{{ url('posts/elevationTime/Month') }}" @if($time == 'Month') class = "navLink" @else class = "indexLink" @endif>Month</a>
                    <a href = "{{ url('posts/elevationTime/Year') }}" @if($time == 'Year') class = "navLink" @else class = "indexLink" @endif>Year</a>
                    <a href = "{{ url('posts/elevationTime/All') }}" @if($time == 'All') class = "navLink" @else class = "indexLink" @endif>All Time</a>
                </li>
            </ul>
        </nav>
    </div>
    <hr class = "contentSeparator">
    @include('posts._postCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])

@stop



