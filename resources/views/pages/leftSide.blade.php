@section('leftSideBar')
    <div>
        <h2>{{$user->handle}}</h2>
        <nav>
            <ul>
                <li><a href={{ url('/home') }}>Home</a></li>
                <li>
                    <a href="{{ url('/posts') }}">Posts<span class="caret"></span></a>
                    <div>
                        <ul>
                            <li><a href={{ url('/posts/create') }}>Create</a></li>
                            <li><a href={{ url('/posts') }}>Discover</a></li>
                            <li><a href="{{ url('/indev') }}">Your Posts</a></li>
                            <li><a href="{{ url('/indev') }}">Extensions</a></li>
                            <li><a href="{{ url('/indev') }}">Bookmarks</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ url('/indev') }}">Directory<span class="caret"></span></a>
                    <div>
                        <ul>
                            <li><a href="{{ url('/indev') }}">Beliefs</a></li>
                            <li><a href="{{ url('/indev') }}">Questions</a></li>
                            <li><a href="{{ url('/indev') }}">Beacons</a></li>
                            <li><a href="{{ url('/indev') }}">Sponsors</a></li>
                            <li><a href="{{ url('/indev') }}">Legacy Posts</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ url('/settings') }}">Settings<span class="caret"></span></a>
                    <div>
                        <ul>
                            <li><a href="{{ url('/settings') }}">View/Change</a></li>
                            <li><a href="{{ url('/indev') }}">Support</a></li>
                            <li><a href="{{ url('/indev') }}">Your Sponsor</a></li>
                            <li><a href="{{ url('/invites') }}">Invite Friends</a></li>
                            <li><a href="https://tre-uniti.org">Tre-Uniti</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
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