@extends('app')
@section('siteTitle')
    Show Beacon
@stop

@section('centerMenu')
    <h2>Deactivate <a href = "{{url('beacons/'. $beacon->beacon_tag)}}">{{ $beacon->name }}</a></h2>
@stop

@section('centerText')

    @if($user->type > 1 || $user->id == $beacon->manager)
        <div class = "indexNav">
            <a href="{{ url('/beacons/invoice/'. $beacon->id )}}"><button type = "button" class = "indexButton">Invoices</button></a>
            <a href="{{ url('/beacons/subscription/'. $beacon->id )}}"><button type = "button" class = "indexButton">Subscription</button></a>
            <a href="{{ url('/intolerances/beacon/'. $beacon->id) }}"><button type = "button" class = "indexButton">Intolerance</button></a>
        </div>
    @endif

    <p>Are you sure you want to deactivate {{ $beacon->name }}?</p>
    <p>All Posts, Extensions, Intolerances, and Bookmarks will be reassigned or removed</p>

    {!! Form::open(['method' => 'DELETE', 'route' => ['beacons.destroy', $beacon->id], 'class' => 'formDeletion']) !!}
    {!! Form::submit('Confirm Deactivation', ['class' => 'navButton', 'id' => 'delete']) !!}
    {!! Form::close() !!}

    <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}"><button type = "button" class = "navButton">Cancel</button></a>


@stop

