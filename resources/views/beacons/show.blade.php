@extends('app')
@section('siteTitle')
    Show Beacon
@stop

@include('beacons.leftSide')

@section('centerMenu')
    <h2>{{ $beacon->name }}</h2>
@stop

@section('centerText')
    <div>
        <table style="display: inline-block;">
            <tr>
                <td><a href="{{ url('/posts/') }}">{{ $beacon->name }}</a>
                </td>
            </tr>
        </table>

        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">

    </div>
@stop

@include('beacons.rightSide')

