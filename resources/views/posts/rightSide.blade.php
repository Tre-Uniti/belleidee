@section('rightSideBar')
    <div id = "rightSide">

            <h2>Inspires</h2>
            <select>
                <option>Inspires 1</option>
            </select>

        <hr/>
        <div class = "innerProfileMenus">
            <h2>Extensions</h2>
            <ul>
                @if ($profileExtensions->isEmpty())
                    <li><a href="{{url('/posts')}}"> <button type = "button" class = "interactButton">Create a new Extension</button></a></li>
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