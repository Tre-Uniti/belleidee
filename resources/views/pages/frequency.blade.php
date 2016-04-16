@extends('app')
@section('siteTitle')
    Settings
@stop
@section('centerText')
    <h2>Email Frequency:</h2>
    <p>You may select how often you want to receive emails from Idee</p>

    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}
    <table class = "formData">
        <tr>
            <th colspan="2">{!! Form::label('frequency', 'Select Frequency') !!}</th>
        </tr>
        <tr>
        <td>
            {!! Form::select('frequency', $frequencies, array('frequency' => $user->frequency)) !!}
        </td>
        </tr>
    </table>
    <p><b>Least:</b> Password resets, support tickets, beacon or sponsor requests</p>
    <p><b>Often:</b> + New community questions and extensions of your content</p>
    <p><b>Most:</b> + Sponsorship promotions sent from your selected sponsor</p>
@stop
@section('centerFooter')
    {!! Form::submit('Update Frequency', ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
@stop