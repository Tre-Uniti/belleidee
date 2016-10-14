@extends('app')
@section('siteTitle')
    Beacon Requests
@stop

@section('centerText')
    <h2>Your Beacon Requests</h2>
    <div id = "indexNav">
        <a href="{{ url('/beacons/')}}" class = "indexLink">All Beacons</a>
        <a href="{{ url('/beaconRequests/create')}}" class = "indexLink">New Request</a>
        <a href="{{ url('/beaconRequests/agreement')}}" class = "indexLink" target ="_blank">Agreement</a>
    </div>

    <hr class = "contentSeparator"/>
    @if(count($beaconRequests) == 0)
        <p>No requests at the moment!</p>
    @else
    @foreach ($beaconRequests as $request)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            <a href = "{{ url('/beaconRequests/'. $request->id) }}">{{$request->name}}</a>
                        </h3>
                    </header>
                </div>

                <div class = "cardHandleSection">
                    <p>
                        Status: <a href = "{{ url('/beaconRequests/'. $request->id) }}" class ="contentHandle">{{$request->status}}</a>
                    </p>
                    <p>Created: {{ $request->created_at->format('M-d-Y')}}</p>
                </div>

            </div>
        </article>
    @endforeach
    @endif
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beaconRequests])
@stop
