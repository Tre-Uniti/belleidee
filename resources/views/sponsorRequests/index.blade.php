@extends('app')
@section('siteTitle')
    Sponsor Requests
@stop

@section('centerText')
    <h2>Your Sponsor Requests</h2>
    <div id = "indexNav">
        <a href="{{ url('/sponsors')}}" class = "indexLink">All Sponsors</a>
        <a href="{{ url('/sponsorRequests/create')}}" class = "indexLink">New Request</a>
        <a href="{{ url('/sponsorRequests/agreement')}}" class = "indexLink" target ="_blank">Agreement</a>
    </div>

    <hr class = "contentSeparator"/>
    @if(count($sponsorRequests) == 0)
        <p>No requests at the moment!</p>
    @else
        @foreach ($sponsorRequests as $request)
            <article>
                <div class = "contentCard">
                    <div class = "cardTitleSection">
                        <header>
                            <h3>
                                <a href = "{{ url('/sponsorRequests/'. $request->id) }}">{{$request->name}}</a>
                            </h3>
                        </header>
                    </div>

                    <div class = "cardHandleSection">
                        <p>
                            Status: <a href = "{{ url('/sponsorRequests/'. $request->id) }}" class ="contentHandle">{{$request->status}}</a>
                        </p>
                        <p>Created: {{ $request->created_at->format('M-d-Y')}}</p>
                    </div>

                </div>
            </article>
        @endforeach
    @endif
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsorRequests])
@stop
