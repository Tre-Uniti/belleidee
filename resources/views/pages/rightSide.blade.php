@section('rightSideBar')
    <div id = "rightSide">
        <div class = "innerProfileMenus">
            <h2>Inspired By:</h2>

            <ul>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 1</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 2</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 3</button></a></li>
            </ul>
        </div>
        <hr/>
        <div class = "innerProfileMenus">
            <h2>Extensions</h2>
            <ul>
                @if ($profileExtensions->isEmpty())
                    <li><a href="{{url('/extension/create')}}"> <button type = "button" class = "interactButton">Create a new Extension</button></a></li>
                @else
                    @foreach($profileExtensions as $profileExtension)
                        <li><a href="{{ action('ExtensionController@show', [$profileExtension->id])}}">
                                <button type = "button" class = "interactButton">{{ $profileExtension->title }}</button></a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <hr/>
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
        </div>
    </div>
@stop