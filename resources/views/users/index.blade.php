@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Users
@stop

@section('centerText')
    <h2>{{ $location }} User Directory</h2>
        <div class = "indexNav">
            <a href="{{ url('/users/following/' . $user->id)}}" class = "indexLink">Following</a>
            @if($user->last_tag != null)
                <a href="{{ url('/beacons/users/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
            @endif
            <a href="{{ url('users/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
            <a href="{{ url('users/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
        </div>
    <hr class = "contentSeparator"/>
    @include ('users._userCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $users])
@stop


