@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Social Sponsor
@stop

@section('centerText')

    <div>
        <h2>Social Button for <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->name }}</a></h2>
        <div class = "indexNav">
            <a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}"><button type = "button" class = "indexButton">About</button></a>
            <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
            <a href="{{ $sponsor->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
        </div>
        @if($user->type > 1 || $user->id == $sponsor->user_id)
            <button class = "interactButton" id = "hiddenIndex">More</button>
        @endif
        <div class = "indexContent" id = "hiddenContent">
            <div>

                <a href = "{{ url('/sponsors/analytics/'. $sponsor->id) }}"><button type = "button" class = "indexButton">Analytics</button></a>
                <a href="{{ url('promotions/sponsor/'. $sponsor->id) }}"> <button type = "button" class = "indexButton">Promotions</button></a>
            </div>
        </div>
    </div>

        <h4>1.  Download desired logo/image</h4>
        <p><a href = "{{secure_asset('img/ideeSocial.png')}}"><img src={{secure_asset('img/ideeSocial.png')}}></a><a href = "{{secure_asset('img/ideeSocial2.png')}}"><img src={{secure_asset('img/ideeSocial2.png')}}></a></a><a href = "{{secure_asset('img/ideeSocial3.png')}}"><img src={{secure_asset('img/ideeSocial3.png')}}></a></p>
        <h4>2.  Copy and paste the code into your website</h4>

            <div class = "formDataContainer">
                <p>{{$sponsorSocialUrl}}</p>
            </div>

        <h4>3.  Modify the code to update the image location on your server</h4>

            <div class = "formDataContainer">
                <p>{{$imageLink}}</p>
            </div>

    <p>Or provide a direct link to your Beacon:</p>
    <p><a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsorUrl }}</a></p>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($user->type > 1)
            <a href="{{ url('/sponsors/'.$sponsor->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
    </div>
@stop

