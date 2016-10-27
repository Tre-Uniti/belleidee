@if(count($supports) == 0)
    <p>No support requests at the moment!</p>
@else
    @foreach ($supports as $support)
        <article>
            <div class = "contentCard">
                <div class = "cardTitleSection">
                    <header>
                        <h3>
                            <a href = "{{ url('/supports/'. $support->id) }}">Support ID: {{$support->id}}</a>
                        </h3>
                        <p>Type: <a href="{{ action('SupportController@show', [$support->id])}}">{{ $support->type }}</a></p>
                    </header>
                </div>

                <div class = "cardHandleSection">
                    <p>
                        Status: <a href = "{{ url('/supports/'. $support->id) }}" class ="contentHandle">{{$support->status}}</a>
                    </p>
                    <p>Created: {{ $support->created_at->format('M-d-Y')}}</p>
                </div>

            </div>
        </article>
    @endforeach
@endif