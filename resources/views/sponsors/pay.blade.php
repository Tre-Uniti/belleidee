@extends('app')
@section('siteTitle')
    Sponsor Payment
@stop

@section('centerText')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="/js/stripe.js"></script>

    @include ('errors.list')

    <h2>Payment for: {{ $sponsor->name }}</h2>
    {!! Form::open(['route' => 'payment', 'role' => 'form', 'id' => 'payment-form'] ) !!}

    <div class="payment-errors"></div>
    <div id="signupalert" class="alert alert-danger">

    </div>
    <div class = "formInput">
        {!! Form::label('sponsor', 'Sponsor ID') !!}
        {!! Form::text('sponsor', $sponsor->id)!!}
    </div>
    <div class = "formInput">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', $sponsor->email, [ 'placeholder' => 'Email' ]) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('ccn', 'Credit card number: ') !!}
        {!! Form::text('ccn', '', ['data-stripe' => 'number' ]) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('expiration', 'Expiration date:') !!}
        {!! Form::selectMonth('month', 'junuary', ['data-stripe' => 'exp-month' ]) !!}
        {!! Form::selectRange('year', 2016, 2022, 2016, ['data-stripe' => 'exp-year' ]) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('cvc', 'CVC number') !!}
        {!! Form::text('cvc', '', ['data-stripe' => 'cvc' ]) !!}
    </div>
    <div class = "formInput">
        (Views: {{ $sponsor->views }}) + (Clicks: {{ $sponsor->clicks }})
    </div>
    <div class = "formInput">
        Total Due: ${{ $sponsor->views * .005 + $sponsor->clicks * .05 }}
    </div>
    <div class = "formInput">
        {!! Form::button('Pay', [ 'type' => 'submit', 'id'  => 'btn-signup', 'class' => 'navButton'] ) !!}
    </div>

    {!! Form::close()  !!}
@stop