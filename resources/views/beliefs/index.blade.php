@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <div>
    <h2>Belief Directory</h2>

    </div>
    <nav class = "beliefNav">
        <ul>
            <li>
                <table align = "center">
                    <tr>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Adaptia') }}"><button type = "button" class = "interactButton">Adaptia</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Atheism') }}"><button type = "button" class = "interactButton">Atheism</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Ba Gua') }}"><button type = "button" class = "interactButton">Ba Gua</button></a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Buddhism') }}"><button type = "button" class = "interactButton">Buddhism</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Christianity') }}"><button type = "button" class = "interactButton">Christianity</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Druze') }}"><button type = "button" class = "interactButton">Druze</button></a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Hinduism') }}"><button type = "button" class = "interactButton">Hinduism</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Islam') }}"><button type = "button" class = "interactButton">Islam</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Judaism') }}"><button type = "button" class = "interactButton">Judaism</button></a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Native') }}"><button type = "button" class = "interactButton">Native</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Taoism') }}"><button type = "button" class = "interactButton">Taoism</button></a></td>
                        <td><a href="{{ action('BeliefController@beliefIndex', 'Urantia') }}"><button type = "button" class = "interactButton">Urantia</button></a></td>
                    </tr>
                </table>
            </li>
        </ul>
    </nav>

@stop
@section('centerFooter')
@stop

@include('posts.rightSide')


