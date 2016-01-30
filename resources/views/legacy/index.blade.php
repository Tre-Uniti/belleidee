@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <div>
    <h2>Legacy Directory</h2>
    </div>
    <p>Legacy posts will appear when more Users become Admins.</p>
    <nav class = "beliefNav">
        <ul>
            <li>
                <table align = "center">
                    <tr>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Adaptia') }}"><button type = "button" class = "interactButton">Adaptia</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Atheism') }}"><button type = "button" class = "interactButton">Atheism</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Ba Gua') }}"><button type = "button" class = "interactButton">Ba Gua</button></a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Buddhism') }}"><button type = "button" class = "interactButton">Buddhism</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Christianity') }}"><button type = "button" class = "interactButton">Christianity</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Druze') }}"><button type = "button" class = "interactButton">Druze</button></a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Hinduism') }}"><button type = "button" class = "interactButton">Hinduism</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Islam') }}"><button type = "button" class = "interactButton">Islam</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Indigenous') }}"><button type = "button" class = "interactButton">Indigenous</button></a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Judaism') }}"><button type = "button" class = "interactButton">Judaism</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Shinto') }}"><button type = "button" class = "interactButton">Shinto</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Sikhism') }}"><button type = "button" class = "interactButton">Sikhism</button></a></td>
                    </tr>
                    <tr>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Taoism') }}"><button type = "button" class = "interactButton">Taoism</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Urantia') }}"><button type = "button" class = "interactButton">Urantia</button></a></td>
                        <td><a href="{{ action('LegacyController@beliefIndex', 'Other') }}"><button type = "button" class = "interactButton">Other</button></a></td>
                    </tr>
                </table>
            </li>
        </ul>
    </nav>

@stop
@section('centerFooter')
@stop

@include('posts.rightSide')


