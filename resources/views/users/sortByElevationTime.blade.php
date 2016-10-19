@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Elevated Users
@stop

@section('centerText')
    <h2>Users ({{ $filter }})</h2>
    <div class = "indexNav">
        <a href="{{ url('/users')}}" class = "indexLink">Recent</a>
        <a href="{{ url('/users/following/'. $user->id) }}" class = "indexLink">Following</a>
        @if($user->last_tag != null)
            <a href="{{ url('/beacons/users/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
        @endif
        <a href="{{ url('users/extensionTime/Month')}}" class = "indexLink">Most  <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> </a>
    </div>

        <p>Sort by  <i class="fa fa-heart" aria-hidden="true"></i> </p>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = "{{ url('users/elevationTime/Today') }}" @if($time == 'Today')class = "navLink" @else class = "indexLink" @endif>Today</a>
                    <a href = "{{ url('users/elevationTime/Month') }}" @if($time == 'Month') class = "navLink" @else class = "indexLink" @endif>Month</a>
                    <a href = "{{ url('users/elevationTime/Year') }}" @if($time == 'Year') class = "navLink" @else class = "indexLink" @endif>Year</a>
                    <a href = "{{ url('users/elevationTime/All') }}" @if($time == 'All') class = "navLink" @else class = "indexLink" @endif>All Time</a>
                </li>
            </ul>
        </nav>
    <hr class = "contentSeparator"/>
    @include ('users._userCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $users])
@stop



