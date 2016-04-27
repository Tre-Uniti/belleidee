@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <div>
    <h2>Legacy Directory</h2>
    </div>
    <p>Legacy posts will appear when more Users become Admins.</p>
    <div class = "contentNav">
    <div class = "contentNavLeft">
        <a href="{{ action('BeliefController@beliefIndex', 'Adaptia') }}"><button type = "button" class = "indexButton">Adaptia</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Atheism') }}"><button type = "button" class = "indexButton">Atheism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Buddhism') }}"><button type = "button" class = "indexButton">Buddhism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Christianity') }}"><button type = "button" class = "indexButton">Christianity</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Druze') }}"><button type = "button" class = "indexButton">Druze</button></a>
    </div>
    <div class = "contentNavLeft">
        <a href="{{ action('BeliefController@beliefIndex', 'Hinduism') }}"><button type = "button" class = "indexButton">Hinduism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Islam') }}"><button type = "button" class = "indexButton">Islam</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Indigenous') }}"><button type = "button" class = "indexButton">Indigenous</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Judaism') }}"><button type = "button" class = "indexButton">Judaism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Shinto') }}"><button type = "button" class = "indexButton">Shinto</button></a>
    </div>
    <div class = 'contentNavLeft'>
        <a href="{{ action('BeliefController@beliefIndex', 'Sikhism') }}"><button type = "button" class = "indexButton">Sikhism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Taoism') }}"><button type = "button" class = "indexButton">Taoism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Urantia') }}"><button type = "button" class = "indexButton">Urantia</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Zoroastrianism') }}"><button type = "button" class = "indexButton">Zoroastrianism</button></a>
        <a href="{{ action('BeliefController@beliefIndex', 'Other') }}"><button type = "button" class = "indexButton">Other</button></a>
    </div>
    </div>
@stop



