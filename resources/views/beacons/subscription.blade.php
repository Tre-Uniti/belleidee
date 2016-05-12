@extends('app')
@section('siteTitle')
    Beacon Subscription
@stop

@section('centerText')
    <h2>Subscription for: {{ $beacon->name }}</h2>

    <div class = "formDataContainer">
        @include ('errors.list')
    {!! Form::open(['route' => 'swap', 'role' => 'form'] ) !!}
    <div class = "formData">
        <div class = "formData">
            {!! Form::label('subscription', 'Subscription Type:') !!}
        </div>
        <div class = "formInput">
            {!! Form::select('subscription' , [ '0' => 'Starter: Free', '1' => 'Small: (<500 people) $25 per month', '2' => 'Medium: (<1000) $50 per month', '3' => 'Large: (>1000) $100 per month'], $beacon->stripe_plan) !!}
        </div>
        {!! Form::hidden('beacon', $beacon->id) !!}
    </div>
        {!! Form::button('Update', [ 'type' => 'submit', 'class' => 'navButton'] ) !!}

        {!! Form::close()  !!}
</div>

@stop
@section('centerFooter')
    <a href = "{{ url('beacons/'. $beacon->id) }}"><button type = "button" class = "navButton">Beacon Profile</button></a>
    <a href = "{{ url('beacons/signup/'. $beacon->id) }}"><button type = "button" class = "navButton">Change Card</button></a>
@stop