@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Top Viewed Sponsors
@stop

@section('centerText')
    <h2>{{ $location }} Most Viewed Sponsors</h2>
        <div class = "indexNav">
            @if(isset($userSponsor))
                <a href="{{ url('/sponsors/' . $userSponsor->sponsor_tag)}}" class = "indexLink">{{ $userSponsor->sponsor_tag }}</a>
            @endif
            <a href="{{ url('/sponsors/topSponsored')}}" class = "indexLink">Top <i class="fa fa-user-plus" aria-hidden="true"></i></a>
            <a href="{{ url('/sponsors')}}" class = "indexLink">Recent </a>
            <a href="{{ url('/sponsorRequests')}}" class = "indexLink">Requests</a>
        </div>
        <p>Filter by:  <i class="fa fa-eye" aria-hidden="true"></i> (views)</p>
        <hr class = "contentSeparator"/>
    @include('sponsors._sponsorCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors])
@stop



