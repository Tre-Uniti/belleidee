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
                    <a href="{{ url('/sponsors') }}">Views</a>
                </th>
                <th>
                    <a href="{{ url('/sponsors') }}">Country</a>
                </th>
                <th>
                    <a href="{{ url('/sponsors') }}">City</a>
                </th>
            </tr>
            <tr>
                <td><a href="{{ url('/posts/') }}">{{ $sponsor->views }}</a>
                </td>
                <td><a href="{{ url('/beacons/tags/'.$sponsor->views) }}">{{ $sponsor->country }}</a>
                </td>
                <td><a href="{{ url('/posts/') }}">{{ $sponsor->city }}</a>
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

@stop

@include('sponsors.rightSide')

