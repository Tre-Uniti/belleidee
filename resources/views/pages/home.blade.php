@extends('app')
@section('siteTitle')
    Home
@stop
@section('leftSideBar')


        <div>
            <h2>Zoko</h2>
            <table style = "display: inline-block;">
                <tr>
                    <th>Posts</th>
                </tr>
                <tr>
                    <td>
                        <select>
                            @if ($profilePosts->isEmpty())
                                <a href="{{url('/post/create')}}"> <button type = "button" class = "interactButton">Create a new Post</button></a>
                            @else
                                @foreach($profilePosts as $profilePost)
                                    <option>
                                        {{ $profilePost->created_at->format('M-d-Y')}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
            </table>

            <table style = "display: inline-block;">
                <tr>
                    <th>Extensions</th>
                </tr>
                <tr>
                    <td><select>
                            @if ($profileExtensions->isEmpty())
                                <a href="{{url('/extension/create')}}"> <button type = "button" class = "interactButton">Create a new Extension</button></a>
                            @else
                                @foreach($profileExtensions as $profileExtension)
                                    <option>
                                        {{ $profileExtension->created_at->format('M-d-Y')}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        </td>
                </tr>
            </table>
            <div class = "innerPhotos">
                <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
            </div>

</div>
    @stop
@section('centerText')
    <h1>Home of {{$user->handle}}</h1>
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extension: 0</button></a>
    <hr/>
    <div style = "width: 50%; float: left;">
    <h2>Influences</h2>
        </div>
    <div style = "width: 50%; float: right;">
    <h2>Extenders</h2>
        </div>


        <div style = "width: 50%; float: left;">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">QueenBee</button></a>
            </div>
    <div style = "width: 50%; float: right;">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Zoko</button></a>
    </div>
    <div style = "width: 50%; float: left;">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Zoko</button></a>
        </div>
    <div style = "width: 50%; float: right;">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">QueenBee</button></a>
    </div>
    <div style = "width: 50%; float: left;">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Amaricus</button></a>
    </div>
    <div style = "width: 50%; float: right;">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Leprechaun720</button></a>
    </div>










@stop
@section('centerFooter')
@stop
@section('rightSideBar')
    <h2>Hosted</h2>
    <table style = "display: inline-block;">
        <tr>
            <th>Beliefs</th>
        </tr>
        <tr>
            <td>
                {!! Form::open(['url' => 'posts']) !!}
                {!! Form::select('index', $categories) !!}
                {!! Form::close()   !!}
            </td>
        </tr>
        </table>
    <table style = "display: inline-block;">
        <tr>
            <th>Legacy</th>
        </tr>
        <tr>
            <td>
                <select>
                    @if ($profilePosts->isEmpty())
                        <a href="{{url('/post/create')}}"> <button type = "button" class = "interactButton">Create a new Post</button></a>
                    @else
                        @foreach($profilePosts as $profilePost)
                            <option>
                                {{ $profilePost->created_at->format('M-d-Y')}}
                            </option>
                        @endforeach
                    @endif
                </select>
            </td>
        </tr>
    </table>
    <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
    </div>








@stop
