@extends('app')
@section('siteTitle')
    Show Belief
@stop

@section('centerText')
    <h2><a href = "{{ url('/beliefs/' . $belief) }}">{{ $belief }}</a></h2>
    <div class = "indexNav">
        <p>Filter by latest:</p>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = "{{ url('/beliefs/posts/' . $belief) }}" @if($type == 'Post') class = "navLink" @else class = "indexLink" @endif>Posts</a>
                    <a href="{{ url('/beliefs/extensions/'. $belief) }}" @if($type == 'Extension') class = "navLink" @else class = "indexLink" @endif>Extensions</a>
                    <a href = "{{ url('/beliefs/legacies/'. $belief) }}" @if($type == 'Legacy') class = "navLink" @else class = "indexLink" @endif>Legacies</a>
                    <a href = "{{ url('/beliefs/beacons/'. $belief) }}" @if($type == 'Beacon') class = "navLink" @else class = "indexLink" @endif>Beacons</a>
                </li>
            </ul>
        </nav>
    </div>
    <hr class = "contentSeparator"/>
    @include('legacyPosts._legacyPostCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop

