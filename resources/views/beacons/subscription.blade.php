@extends('app')
@section('siteTitle')
    Beacon Subscription
@stop

@section('centerText')

    @include ('errors.list')

    <h2>Subscription for: {{ $beacon->name }}</h2>
    <div class = "formDataContainer">
    <p>Current subscription:</p>
    @if($beacon->stripe_plan == 0)
        <p>Free community:  $0/month</p>
    @elseif($beacon->stripe_plan == 1)
        <p>Small community: $25/month</p>
    @elseif($beacon->stripe_plan == 2)
        <p>Medium community: $50/month</p>
    @elseif($beacon->stripe_plan == 3)
        <p>Large community: $100/month</p>
    @endif
    {!! Form::open(['route' => 'swap', 'role' => 'form'] ) !!}
    <div class = "formData">
        <div class = "formData">
            {!! Form::label('subscription', 'Change subscription to:') !!}
        </div>
        <div class = "formInput">
            {!! Form::select('subscription' , [ '0' => 'Starter: Free', '1' => 'Small: (<500 people) $25 per month', '2' => 'Medium: (<1000) $50 per month', '3' => 'Large: (>1000) $100 per month']) !!}
        </div>
        {!! Form::hidden('beacon', $beacon->id) !!}
    </div>

</div>
    {!! Form::button('Update', [ 'type' => 'submit', 'class' => 'navButton'] ) !!}

    {!! Form::close()  !!}
@stop