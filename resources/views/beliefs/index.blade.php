@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <h2>Belief Directory</h2>
    <div class = "indexNav">
                <a href="{{ action('BeliefController@beliefIndex', 'Adaptia') }}"><button type = "button" class = "indexButton">Adaptia</button></a>
                <a href="{{ action('BeliefController@beliefIndex', 'Atheism') }}"><button type = "button" class = "indexButton">Atheism</button></a>
                <a href="{{ action('BeliefController@beliefIndex', 'Ba Gua') }}"><button type = "button" class = "indexButton">Ba Gua</button></a>
                <a href="{{ action('BeliefController@beliefIndex', 'Buddhism') }}"><button type = "button" class = "indexButton">Buddhism</button></a>
    </div>
    <div class = "indexNav">
        <a href="{{ action('BeliefController@beliefIndex', 'Christianity') }}"><button type = "button" class = "indexButton">Christianity</button></a>
                <a href="{{ action('BeliefController@beliefIndex', 'Druze') }}"><button type = "button" class = "indexButton">Druze</button></a>
                <a href="{{ action('BeliefController@beliefIndex', 'Hinduism') }}"><button type = "button" class = "indexButton">Hinduism</button></a>
                <a href="{{ action('BeliefController@beliefIndex', 'Islam') }}"><button type = "button" class = "indexButton">Islam</button></a>
    </div>
    <div class = "indexNav">
        <a href="{{ action('BeliefController@beliefIndex', 'Indigenous') }}"><button type = "button" class = "indexButton">Indigenous</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Judaism') }}"><button type = "button" class = "indexButton">Judaism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Shinto') }}"><button type = "button" class = "indexButton">Shinto</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Sikhism') }}"><button type = "button" class = "indexButton">Sikhism</button></a>
    </div>
    <div class = "indexNav">
        <a href="{{ action('BeliefController@beliefIndex', 'Taoism') }}"><button type = "button" class = "indexButton">Taoism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Urantia') }}"><button type = "button" class = "indexButton">Urantia</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Zoroastrianism') }}"><button type = "button" class = "indexButton">Zoroastrianism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Other') }}"><button type = "button" class = "indexButton">Other</button></a>
    </div>

@stop




