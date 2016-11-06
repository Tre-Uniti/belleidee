@extends('app')
@section('siteTitle')
    Intolerances
@stop

@section('centerText')
    <h2>Recent Intolerances</h2>
    <div class = "indexNav">
       <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Sort by Oldest</button></a>
        <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Sort by Type</button></a>
    </div>
<hr class = "contentSeparator"/>
    @include('intolerances._intoleranceCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $intolerances])
@stop



