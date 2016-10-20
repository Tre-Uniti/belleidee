@extends('app')
@section('siteTitle')
    Beacon Users
@stop
@section('centerText')
    <h2><a href={{ url('/beacons/'. $beacon->beacon_tag)}}>{{$beacon->name}}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/beacons/'. $beacon->beacon_tag)}}" class = "indexLink">Profile</a>
        <a href="{{ url('/beacons/contact/' . $beacon->beacon_tag)}}" class = "indexLink">Contact</a>
        <p>Users connected to: <a href = "{{ url('/beacons/' . $beacon->beacon_tag) }}" class = "contentHandle">{{ $beacon->beacon_tag }}</a></p>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href="{{ url('/beacons/guide/'.$beacon->beacon_tag)}}" @if($type == 'Guide')class = "navLink" @else class = "indexLink" @endif>Guide</a>
                    <a href = "{{ url('/beacons/posts/' . $beacon->beacon_tag) }}" @if($type == 'Posts') class = "navLink" @else class = "indexLink" @endif>Posts</a>
                    <a href = "{{ url('/beacons/extensions/'. $beacon->beacon_tag) }}" @if($type == 'Extensions') class = "navLink" @else class = "indexLink" @endif>Extensions</a>
                    <a href = "{{ url('/beacons/users/'. $beacon->beacon_tag) }}" @if($type == 'Users') class = "navLink" @else class = "indexLink" @endif>Users</a>
                </li>
            </ul>
        </nav>
    </div>
    <hr class = "contentSeparator"/>
    @include('users._userCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $users])
@stop