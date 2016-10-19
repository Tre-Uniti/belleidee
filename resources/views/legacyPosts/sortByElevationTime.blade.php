@extends('app')
@section('siteTitle')
    Elevated Legacy
@stop

@section('centerText')
    <h2>Top Legacy ({{ $filter }})</h2>
    <div id = "indexNav">
        <a href="{{ url('/legacyPosts/forYou')}}" class = "indexLink">For You</a>
        <a href="{{ url('/legacyPosts')}}" class = "indexLink">Recent</a>
        <a href="{{ url('/legacyPosts/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
            <p>Sort by <i class="fa fa-heart" aria-hidden="true"></i></p>

            <nav class = "infoNav">
                <ul>
                    <li>
                        <a href = "{{ url('legacyPosts/elevationTime/Today') }}" @if($time == 'Today')class = "navLink" @else class = "indexLink" @endif>Today</a>
                        <a href = "{{ url('legacyPosts/elevationTime/Month') }}" @if($time == 'Month') class = "navLink" @else class = "indexLink" @endif>Month</a>
                        <a href = "{{ url('legacyPosts/elevationTime/Year') }}" @if($time == 'Year') class = "navLink" @else class = "indexLink" @endif>Year</a>
                        <a href = "{{ url('legacyPosts/elevationTime/All') }}" @if($time == 'All') class = "navLink" @else class = "indexLink" @endif>All Time</a>
                    </li>
                </ul>
            </nav>

    <hr class = "contentSeparator"/>
    @include('legacyPosts._legacyPostCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])

@stop



