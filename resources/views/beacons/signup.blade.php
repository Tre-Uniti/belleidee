@extends('app')
@section('siteTitle')
    Subscribe Beacon
@stop

@section('centerText')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('pk_test_5UQPslTg5VlQSDkE64mtG7TJ');
        var stripeResponseHandler = function(status, response) {
            var $form = $('#subscription-form');
            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
            } else {
                // token contains id, last4, and card type
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and re-submit
                $form.get(0).submit();
            }
        };
        jQuery(function($) {
            $('#subscription-form').submit(function(e) {
                var $form = $(this);
                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);
                Stripe.card.createToken($form, stripeResponseHandler);
                // Prevent the form from submitting with the default action
                return false;
            });
        });
    </script>

    @include ('errors.list')

    <h2>Subscribe: {{ $beacon->name }}</h2>
    {!! Form::open(['route' => 'subscribe', 'role' => 'form', 'id' => 'subscription-form'] ) !!}

    <div class="payment-errors"></div>
    <div id="signupalert" style="display:none" class="alert alert-danger">
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
                {!! Form::selectRange('year', 2015, 2022, 2015, ['data-stripe' => 'exp-year' ]) !!}
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