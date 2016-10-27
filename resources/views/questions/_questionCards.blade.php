@if(count($questions) == 0)
    <p>No Questions yet!</p>
@else
    @foreach ($questions as $question)
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <h4>
                    <a href = "{{ url('/questions/' . $question->id) }}">{{ $question->question }}</a>
                </h4>
            </div>
            <div class = "cardHandleSection">
                <p>
                    Asked By: <a href="{{ action('UserController@show', [$question->user_id])}}" class = "contentHandle">{{ $question->user->handle }}</a> on {{ $question->created_at->format('M-d-Y') }}
                </p>
            </div>
            <div class = "footerSection">
                <div class = "leftSection">
                    <div class = "leftIcon">
                        @if($question->elevationStatus === 'Elevated')
                            <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                        @else
                            <a href="{{ url('/questions/elevate/'.$question->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                        @endif
                        <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                    </div>
                    <div class = "leftCounter">
                        <a href={{ url('/questions/list/elevation/'.$question->id)}}>{{ $question->elevation }}</a>
                    </div>
                </div>

                <div class = "centerSection">
                </div>

                <div class = "rightSection">
                    <div class = "rightIcon">
                        <a href="{{ url('/extensions/question/'.$question->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                        <span class="tooltiptext">Extend to add any inspiration you received</span>
                    </div>
                    <div class = "rightCounter">
                        <a href={{ url('/questions/showAnswers/'.$question->id)}}>{{ $question->extension }}</a>
                    </div>
                </div>
                <!--<div class = "moreSection">
                    <p class = "moreOptions"><i class="fa fa-angle-up fa-lg" aria-hidden="true"></i></p>
                    <div class="moreOptionsMenu">
                        <a href="https://www.facebook.com/share.php?u={{Request::url()}}&title={{$question->$question}}" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/intent/tweet?status={{$question->question}} - {{Request::url()}}" target="_blank"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a>
                        <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>
                    </div>
                </div>-->
            </div>
        </div>
    @endforeach
@endif