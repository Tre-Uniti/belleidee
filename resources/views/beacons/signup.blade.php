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

    <h2>Subscribe: {{ $beacon->name }}</h2>
    {!! Form::open(['route' => 'subscribe', 'role' => 'form', 'id' => 'payment-form'] ) !!}

    <div class="payment-errors"></div>
    <div id="signupalert" class="alert alert-danger">
        <p>Error:</p>
        <span></span>
    </div>
    <table align = "center">
        <tr>
            <td>{!! Form::label('subscription', 'Subscription plan') !!}</td>
            <td>{!! Form::select('subscription' , [ '0' => 'Starter: Free', '1' => 'Small: (<500) 25$ per month', '2' => 'Medium: (<1000) $50 per month', '3' => 'Large: (>1000) $100 per month']) !!}</td>
        </tr>
        <tr>
            <td>{!! Form::label('beacon', 'Beacon') !!}</td>
            <td>{!! Form::text('beacon', $beacon->id, [ 'placeholder' => 'Beacon' ]) !!}</td>
        </tr>
        <tr>
            <td>{!! Form::label('email', 'Email') !!}</td>
            <td>{!! Form::email('email', $beacon->email, [ 'placeholder' => 'Email' ]) !!}</td>
        </tr>
        <tr>
            <td>{!! Form::label('ccn', 'Credit card number') !!}</td>
            <td>{!! Form::text('ccn', '', ['data-stripe' => 'number' ]) !!}</td>
        </tr>
        <tr>
            <td>{!! Form::label('expiration', 'Expiration date') !!}</td>
            <td>{!! Form::selectMonth('month', 'junuary', ['data-stripe' => 'exp-month' ]) !!}
                {!! Form::selectRange('year', 2016, 2022, 2016, ['data-stripe' => 'exp-year' ]) !!}
            </td>
        </tr>
        <tr>
            <td>{!! Form::label('cvc', 'CVC number') !!}</td>
            <td>{!! Form::text('cvc', '', ['data-stripe' => 'cvc' ]) !!}</td>
        </tr>
        <tr>
            <td colspan = "3">{!! Form::button('Sign Up', [ 'type' => 'submit', 'id'  => 'btn-signup', 'class' => 'navButton'] ) !!}</td>
        </tr>
    </table>
    {!! Form::close()  !!}
@stop