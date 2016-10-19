@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Followed by {{ $user->handle }}
@stop

@section('centerText')
    <div>
        <h2>Followed by <a href = "{{ url('users/'. $user->id) }}">{{ $user->handle }}</a></h2>
        <div class = "indexNav">
            <a href="{{ URL::previous() }}" class = "indexLink">Go Back</a>
            <a href="{{ url('/users/' . $user->id)}}" class = "indexLink">Profile</a>
        </div>
    </div>
    <hr class = "contentSeparator">
    @if(isset($users))
        @include('users._userCards')
    @else
        <p>Find a user to follow <a href = " {{ url('/users') }}">here</a></p>
    @endif

@stop


