@extends('app')
@section('siteTitle')
    Discover
@stop
@section('handle')
    {{Auth::user()->handle}}
@stop
@section('centerMenu')
    @if (count($errors) > 0)
        @include('errors.list')
    @endif
@stop
@section('centerText')
    <section>
        <h1>Articles on: Fruit</h1>

        <article>
            <h2>Apple</h2>
            <p>The apple is the pomaceous fruit of the apple tree...</p>
        </article>

        <article>
            <h2>Orange</h2>
            <p>The orange is a hybrid of ancient cultivated origin, possibly between pomelo and tangerine...</p>
        </article>

        <article>
            <h2>Banana</h2>
            <p>Bananas come in a variety of sizes and colors when ripe, including yellow, purple, and red...</p>
        </article>

    </section>
@stop
@section('centerFooter')
    <h2>test</h2>
@stop

