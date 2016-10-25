@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    <h2>
        @if(isset($source->post_id))
            <a href = "{{ url('/extensions/'. $source->id) }}"> Extension</a> of
            <a href = "{{ url('/posts/' . $source->post_id) }}">a Post</a>
        @elseif(isset($source->legacy_post_id))
            <a href = "{{ url('/extensions/'. $source->id) }}"> Extension</a> of
            <a href = "{{ url('/legacyPosts/' . $source->legacy_post_id) }}">a Legacy</a>
        @elseif(isset($source->extenception))
            <a href = "{{ url('/extensions/' . $source->id) }}"> Extension</a> of
            <a href = "{{ url('/extensions/' . $source->extenception) }}">previous Extension</a>
        @elseif(isset($source->question_id))
            <a href = "{{ url('/extensions/'. $source->id) }}">Answer</a> to
            <a href = "{{ url('/questions/' . $source->question_id) }}">a Question</a>
        @endif
    </h2>
    <div class = "indexNav">
        <a href={{ url('/extensions/'. $source->id)}}><button type = "button" class = "indexButton">Back</button></a>
        <a href={{ url('/extensions/'. $source->id)}}><button type = "button" class = "indexButton">Total: {{ $source->extension }}</button></a>
        <a href={{ url('/extensions/listElevation/'.$source->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
    </div>

    <hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
