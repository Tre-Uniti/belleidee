@extends('app')
@section('siteTitle')
    Discover
@stop

@include('extensions.leftSide')

@section('centerText')
    <h2>Discover New Extensions</h2>
    <h4>Sort by:</h4>
    <section>
        @foreach ($extensions as $extension)
            <article>
                <table align = "center" cellpadding = "15">
                    <thead>
                    <tr>
                        <td colspan="2"><h4><a href="{{ action('ExtensionController@show', [$extension->id])}}"> {{ $extension->title }}</a></h4></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 100 300{{$extension->elevation}}</button></a></td>
                        <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 53{{$extension->extension}}</button></a></td>
                    </tr>
                    </tbody>
                </table>
            </article>
            <br/>
        @endforeach

    </section>

@stop
@section('centerFooter')

@stop

@include('posts.rightSide')