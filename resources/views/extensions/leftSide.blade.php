@section('leftSideBar')
    <div>
        <h2>{{$user->handle}}</h2>
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