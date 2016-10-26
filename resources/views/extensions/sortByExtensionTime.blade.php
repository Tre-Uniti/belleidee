@extends('app')
@section('siteTitle')
    Most Extended
@stop

@section('centerText')
    <h2>Most Extended Extensions ({{ $filter }})</h2>
    <div id = "indexNav">
        <a href="{{ url('/extensions/forYou')}}" class = "indexLink">For You</a>
        @if($user->last_tag != null)
            <a href="{{ url('/beacons/extensions/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
        @endif        <a href="{{ url('extensions/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Sort by <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></p>
    <nav class = "infoNav">
        <ul>
            <li>
                <a href = "{{ url('extensions/extensionTime/Today') }}" @if($time == 'Today')class = "navLink" @else class = "indexLink" @endif>Today</a>
                <a href = "{{ url('extensions/extensionTime/Month') }}" @if($time == 'Month') class = "navLink" @else class = "indexLink" @endif>Month</a>
                <a href = "{{ url('extensions/extensionTime/Year') }}" @if($time == 'Year') class = "navLink" @else class = "indexLink" @endif>Year</a>
                <a href = "{{ url('extensions/extensionTime/All') }}" @if($time == 'All') class = "navLink" @else class = "indexLink" @endif>All Time</a>
            </li>
        </ul>
    </nav>
    <hr class = "contentSeparator">
    @include('extensions._extensionTitleCards')
@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
