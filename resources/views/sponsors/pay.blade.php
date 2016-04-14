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
    <div id="signupalert" style="display:none" class="alert alert-danger">
        <p>Error:</p>
        <span></span>
    </div>
    <table align = "center">
        <tr>
            <td>{!! Form::label('sponsor', 'Sponsor ID') !!}</td>
            <td>{!! Form::text('sponsor', $sponsor->id)!!}</td>
        </tr>
        <tr>
            <td>Views:</td><td> {{ $sponsor->views }}</td>
        </tr>
        <tr>
            <td>Clicks:</td><td> {{ $sponsor->clicks }}</td>
        </tr>
        <tr>
            <td>{!! Form::label('email', 'Email') !!}</td>
            <td>{!! Form::email('email', $sponsor->email, [ 'placeholder' => 'Email' ]) !!}</td>
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
            <td>Total Due:</td><td>${{ $sponsor->views * .005 + $sponsor->clicks * .05 }}</td>
        </tr>
        <tr>
            <td colspan = "3">{!! Form::button('Pay', [ 'type' => 'submit', 'id'  => 'btn-signup', 'class' => 'navButton'] ) !!}</td>
        </tr>
    </table>
    {!! Form::close()  !!}
@stop