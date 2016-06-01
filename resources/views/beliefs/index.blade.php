@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <h2>Belief Directory</h2>
    <div class = "contentNav">
        <div class = "contentNavLeft">
            <a href="{{ action('BeliefController@show', 'Adaptia') }}"><button type = "button" class = "indexButton">Adaptia</button></a>
            <a href="{{ action('BeliefController@show', 'Atheism') }}"><button type = "button" class = "indexButton">Atheism</button></a>
            <a href="{{ action('BeliefController@show', 'Buddhism') }}"><button type = "button" class = "indexButton">Buddhism</button></a>
            <a href="{{ action('BeliefController@show', 'Christianity') }}"><button type = "button" class = "indexButton">Christianity</button></a>
            <a href="{{ action('BeliefController@show', 'Druze') }}"><button type = "button" class = "indexButton">Druze</button></a>
        </div>
        <div class = "contentNavLeft">
            <a href="{{ action('BeliefController@show', 'Hinduism') }}"><button type = "button" class = "indexButton">Hinduism</button></a>
            <a href="{{ action('BeliefController@show', 'Islam') }}"><button type = "button" class = "indexButton">Islam</button></a>
            <a href="{{ action('BeliefController@show', 'Indigenous') }}"><button type = "button" class = "indexButton">Indigenous</button></a>
            <a href="{{ action('BeliefController@show', 'Judaism') }}"><button type = "button" class = "indexButton">Judaism</button></a>
            <a href="{{ action('BeliefController@show', 'Shinto') }}"><button type = "button" class = "indexButton">Shinto</button></a>
        </div>
        <div class = 'contentNavLeft'>
            <a href="{{ action('BeliefController@show', 'Sikhism') }}"><button type = "button" class = "indexButton">Sikhism</button></a>
            <a href="{{ action('BeliefController@show', 'Taoism') }}"><button type = "button" class = "indexButton">Taoism</button></a>
            <a href="{{ action('BeliefController@show', 'Urantia') }}"><button type = "button" class = "indexButton">Urantia</button></a>
            <a href="{{ action('BeliefController@show', 'Zoroastrianism') }}"><button type = "button" class = "indexButton">Zoroastrianism</button></a>
            <a href="{{ action('BeliefController@show', 'Other') }}"><button type = "button" class = "indexButton">Other</button></a>
        </div>

    </div>

@stop

@section('centerFooter')
    @if($user->type > 1)
        <a href = {{ url('/beliefs/create') }}><button type = "button" class = "navButton">Create</button></a>
    @endif
@stop



