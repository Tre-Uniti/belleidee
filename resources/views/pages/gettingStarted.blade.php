@extends('app')
@section('siteTitle')
    Getting Started
@stop

@section('centerText')
    <h2>Getting Started</h2>
    <table align = "center">
        <tr>
            <th colspan="2">Create:</th>
        </tr>
        <tr>
            <td><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Public post</button></a></td>
            <td><a href="{{ url('/drafts/create') }}"><button type = "button" class = "interactButton">Private draft</button></a></td>

        </tr>
    </table>
    <table align = 'center'>
        <tr>
            <th colspan="2">Discover:</th>
        </tr>
        <tr>
            <td><a href="{{ url('/posts') }}"><button type = "button" class = "interactButton">New Posts</button></a></td>
            <td><a href="{{ url('/extensions') }}"><button type = "button" class = "interactButton">New Extensions</button></a></td>
        </tr>
    </table>
    <table align = "center">
        <tr>
            <th colspan="3">Community:</th>
        </tr>
        <tr>
            <td><a href="{{ url('/beacons') }}"><button type = "button" class = "interactButton">Beacons</button></a></td>
            <td><a href = "{{ url('/questions') }}"><button type = "button" class = "interactButton">Questions</button></a></td>
            <td><a href="{{ url('/sponsors') }}"><button type = "button" class = "interactButton">Sponsors</button></a></td>
        </tr>
    </table>
@stop

@section('centerFooter')
    <a href="{{ url('/tutorials') }}"><button type = "button" class = "navButton">Tutorials</button></a>
@stop


