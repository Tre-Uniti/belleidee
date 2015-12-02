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