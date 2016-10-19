@extends('app')
@section('pageHeader')
    <script src = '/js/index.js'></script>
@stop
@section('siteTitle')
    Sponsors
@stop

@section('centerText')
    <h2>{{ $location }} Sponsor Directory</h2>

    <div class = "indexNav">
        @if(isset($userSponsor))
        <a href="{{ url('/sponsors/' . $userSponsor->sponsor_tag)}}" class = "indexLink">{{ $userSponsor->sponsor_tag }}</a>
        @endif
        <a href="{{ url('/sponsors/topSponsored')}}" class = "indexLink">Top <i class="fa fa-user-plus" aria-hidden="true"></i></a>
        <a href="{{ url('/sponsors/topViewed')}}" class = "indexLink">Most <i class="fa fa-eye" aria-hidden="true"></i></a>
        <a href="{{ url('/sponsorRequests')}}" class = "indexLink">Requests</a>
    </div>
    <p>Sponsor: A business or non-profit promoting within Belle-idee</p>
    <hr class = "contentSeparator"/>
    @include('sponsors._sponsorCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors])
@stop


