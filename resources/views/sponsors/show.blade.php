@extends('app')
@section('siteTitle')
    Show Draft
@stop

@section('centerMenu')
    <h2>{{ $sponsor->name }}</h2>
@stop

@section('centerText')
    <div>
        <table style="display: inline-block;">
            <tr>
                <th>
                    Location
                </th>
                <th>
                    Views
                </th>
                <th>
                    Clicks
                </th>
            </tr>
            <tr>
                <td><a href="{{ url('/indev') }}">{{ $sponsor->country }}-{{ $sponsor->location }}</a>
                </td>
                <td><a href="{{ url('/indev') }}">{{ $sponsor->views }}</a>
                </td>
                <td><a href="{{ url('/indev') }}">{{ $sponsor->clicks }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <a href="{{ $sponsor->website }}" target="_blank">Sponsor Website</a>
                </td>
            </tr>
        </table>
        <hr/>
        <h2>Promotions</h2>
    </div>
@stop

@section('centerFooter')
    @if($user->type > 1)
        <a href="{{ url('/sponsors/'.$sponsor->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
    @if($user->type > 1 || $user->id == $sponsor->user_id)
        <a href="{{ url('/sponsors/pay/'. $sponsor->id) }}"><button type = "button" class = "navButton">Pay</button></a>
    @endif
        <a href="{{ url('/sponsors/sponsorship/'.$sponsor->id) }}"><button type = "button" class = "navButton">Start Sponsorship</button></a>
@stop

