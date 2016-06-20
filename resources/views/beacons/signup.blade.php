@extends('app')
@section('siteTitle')
    Subscribe Beacon
@stop
@section('pageHeader')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="/js/stripe.js"></script>
@stop

@section('centerText')

    @include ('errors.list')

    <h2>Subscribe: <a href = "{{url('beacons/'. $beacon->id)}}">{{ $beacon->name }}</a></h2>
    {!! Form::open(['route' => 'subscribe', 'role' => 'form', 'id' => 'payment-form'] ) !!}

    <div class="payment-errors">
    <div id="signupalert">
        <p></p>
        <span></span>
    </div>
    </div>
    <div class = "formDataContainer">
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('subscription', 'Subscription plan') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('subscription', [ '0' => 'Starter: Free', '1' => 'Small: (<500) 25$ per month', '2' => 'Medium: (<1000) $50 per month', '3' => 'Large: (>1000) $100 per month'], $beacon->stripe_plan, ['class' => 'selectMenu']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('email', 'Email') !!}
            </div>
            <div class = "formInput">
                {!! Form::email('email', $beacon->email, [ 'placeholder' => 'Email' ]) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('ccn', 'Credit card number') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('ccn', '', ['data-stripe' => 'number']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('expiration', 'Expiration date') !!}
            </div>
            <div class = "formInput">
                {!! Form::selectMonth('month', 'junuary', ['data-stripe' => 'exp-month' ]) !!}
                {!! Form::selectRange('year', 2016, 2022, 2016, ['data-stripe' => 'exp-year' ]) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('cvc', 'CVC number') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('cvc', '', ['data-stripe' => 'cvc' ]) !!}
            </div>
        </div>
        {!! Form::hidden('beacon', $beacon->id, [ 'placeholder' => 'Beacon' ]) !!}

        {!! Form::button('Add Card', [ 'type' => 'submit', 'id'  => 'btn-signup', 'class' => 'navButton'] ) !!}

    {!! Form::close()  !!}
    </div>
@stop

        @section('centerFooter')
            <a href = "{{ url('beacons/'. $beacon->id) }}"><button type = "button" class = "navButton">Beacon Profile</button></a>
            <a href = "{{ url('beacons/subscription/'. $beacon->id) }}"><button type = "button" class = "navButton">Subscriptions</button></a>
            <a href = "{{ url('beacons/invoice/'. $beacon->id) }}"><button type = "button" class = "navButton">Invoices</button></a>

@stop