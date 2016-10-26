@if(!count($promotions))
    <p>No Promotions to show</p>
@else
    @foreach ($promotions as $promotion)
        @if($promotion->status == 'Eligible Only')
            @if($user->id == $sponsor->user_id || $eligibleUser == 'yes')
                <article>
                    <div class = "contentCard">
                        <div class = "cardTitleSection">
                            <header>
                                <h3>
                                    <a href = "{{ url('/promotions/'. $promotion->id) }}">{{$promotion->title}}</a>
                                </h3>
                            </header>
                        </div>

                        <div class = "indexNav">
                            <p>{{ $promotion->description }}</p>
                        </div>
                        <div class = "cardHandleSection">
                            <p>
                                Created: {{ $promotion->created_at->format('M-d-Y') }}
                            </p>
                        </div>
                    </div>
                </article>
            @endif
        @elseif($promotion->status == 'Open to All')
            <article>
                <div class = "contentCard">
                    <div class = "cardTitleSection">
                        <header>
                            <h3>
                                <a href = "{{ url('/promotions/'. $promotion->id) }}">{{$promotion->title}}</a>
                            </h3>
                        </header>
                    </div>

                    <div class = "indexNav">
                        <p>{{ $promotion->description }}</p>
                    </div>
                    <div class = "cardHandleSection">
                        <p>
                            Created: {{ $promotion->created_at->format('M-d-Y') }}
                        </p>
                    </div>
                </div>
            </article>
        @endif
    @endforeach
@endif