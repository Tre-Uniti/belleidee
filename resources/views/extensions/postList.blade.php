@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    @if(isset($sources['extenception']))
        <h2>Extensions of <a href = {{ action('ExtensionController@show', [$sources['extenception']])}}> {{ $sources['extension_title'] }}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/extensions/'. $extension->id)}}><button type = "button" class = "indexButton">Back</button></a>
            <a href={{ url('/extensions/'. $extension->id)}}><button type = "button" class = "indexButton">Total: {{ $extension->elevation }}</button></a>
            <a href={{ url('/extensions/listElevation/'.$extension->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
        </div>
    @else
        <h2>Extensions of <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/posts/'. $post->id)}}><button type = "button" class = "indexButton">Back</button></a>
            <a href={{ url('/posts/'. $post->id)}}><button type = "button" class = "indexButton">Total: {{ $post->elevation }}</button></a>
            <a href={{ url('/posts/listElevation/'.$post->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
        </div>
    @endif

    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>User</h4>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    {!! $extensions->render() !!}
@stop
