@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Extended Legacy
@stop
@section('centerText')
    <h2>Most Extended Legacy ({{$filter}})</h2>
        <div id = "indexNav">
            <a href="{{ url('/legacyPosts/forYou')}}" class = "indexLink">For You</a>
            <a href="{{ url('/legacyPosts/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
            <a href="{{ url('/legacyPosts')}}" class = "indexLink">Recent</a>
        </div>
    <p>Filter by:  <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></p>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = "{{ url('legacyPosts/extensionTime/Today') }}" @if($time == 'Today')class = "navLink" @else class = "indexLink" @endif>Today</a>
                    <a href = "{{ url('legacyPosts/extensionTime/Month') }}" @if($time == 'Month') class = "navLink" @else class = "indexLink" @endif>Month</a>
                    <a href = "{{ url('legacyPosts/extensionTime/Year') }}" @if($time == 'Year') class = "navLink" @else class = "indexLink" @endif>Year</a>
                    <a href = "{{ url('legacyPosts/extensionTime/All') }}" @if($time == 'All') class = "navLink" @else class = "indexLink" @endif>All Time</a>
                </li>
            </ul>
        </nav>

    <hr class = "contentSeparator"/>
    @include('legacyPosts._legacyPostCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop



