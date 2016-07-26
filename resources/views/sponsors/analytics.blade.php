@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Analytics for Sponsor
@stop

@section('centerText')
    <div>
    <h2>Analytics for {{ $sponsor->name }}</h2>
        <div class = "indexNav">
            <a href="{{ url('/sponsors//'. $sponsor->sponsor_tag) }}"><button type = "button" class = "indexButton">Sponsor Profile</button></a>
            <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
            <a href="{{ $sponsor->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
        </div>
        @if($user->type > 1 || $user->id == $sponsor->user_id)
    <button class = "interactButton" id = "hiddenIndex">More</button>
        @endif
        <div class = "indexContent" id = "hiddenContent">
            <div>
                <a href = "{{ url('/sponsors/social/'. $sponsor->id) }}"><button type = "button" class = "indexButton">Social Button</button></a>
                <a href="{{ url('promotions/sponsor/'. $sponsor->id) }}"> <button type = "button" class = "indexButton">Promotions</button></a>
            </div>
        </div>
        </div>

    <table>
        <tr>
            <th>Views</th>
            <th>Clicks</th>
            <th>Missed</th>
        </tr>
        <tr>
            <td>{{ $sponsor->views }}</td>
            <td>{{ $sponsor->clicks }}</td>
            <td>{{ $sponsor->missed }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <th>Sponsorships</th>
            <th>Eligble Users</th>
            <th>Promotions</tH>
        </tr>
        <tr>
            <td>{{ $sponsor->sponsorships }}</td>
            <td>{{ $eligibleCount }}</td>
            <td>{{ $promotions }}</td>
        </tr>
    </table>

@stop

@section('centerFooter')

    @if($user->type > 1)
        <a href="{{ url('/sponsors/'.$sponsor->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif

@stop

