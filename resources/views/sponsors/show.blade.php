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
                    <a href="{{ url('/sponsors') }}">Location</a>
                </th>
                <th>
                    <a href="{{ url('/sponsors') }}">Views</a>
                </th>
                <th>
                    <a href="{{ url('/sponsors') }}">Status</a>
                </th>
            </tr>
            <tr>
                <td><a href="{{ url('/indev') }}">{{ $sponsor->country }}-{{ $sponsor->city }}</a>
                </td>
                <td><a href="{{ url('/indev') }}">{{ $sponsor->views }}</a>
                </td>
                <td><a href="{{ url('/indev') }}">{{ $sponsor->status }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <a href="{{ $sponsor->website }}">Sponsor Website</a>
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
        <a href="{{ url('/sponsors/sponsorship/'.$sponsor->id) }}"><button type = "button" class = "navButton">Start Sponsorship</button></a>
@stop

