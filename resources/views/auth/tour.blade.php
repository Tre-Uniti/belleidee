@extends('auth')
@section('loginTitle')
    Tour
@stop
@section('login')
    <h3>What is Belle-Idee?</h3>
    <ul style = "color: white;">
        <li>A community of belief journeyers</li>
        <li>Beacon Centers: Places of Worship or Belief</li>
        <li>Users who localize posts with Beacon Tags</li>
        <li>Users with sponsors who grant promotions</li>
        <li>https://github.com/Tre-Uniti/belle-idee</li>
        <li>Posts subject to intolerance ruling by users/mods</li>
        <li>A User wins the Weekly Question to ask the next.</li>
    </ul>
    <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">I'd like to Join!</button></a>
@stop
@section('footer')
    <a href="https://duckduckgo.com/"><button type = "button" class = "interactButton">Not Interested</button></a>
@stop
@endsection