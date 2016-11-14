@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">
    <div class = "formInput">
        {!! Form::label('title', 'Title:', ['class' => 'tagLabel']) !!}
    </div>
    <div class = "formData">
        {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('belief', 'Belief:', ['class' => 'tagLabel']) !!}
    </div>
    <div class = "formData">
        {!! Form::select('belief', $beliefs, $legacyPost->belief, ['class' => 'tagSelector']) !!}
    </div>

    @if($type != 'txt')
        <div class = "photoContent">
            {!! Form::textarea('caption', null, ['id' => 'createBodyText', 'placeholder' => 'Add optional caption:', 'rows' => '2%', 'maxlength' => '255']) !!}
            <a href={{ url('/legacyPosts/'. $legacyPost->id) }}><img src= {{ url(env('IMAGE_LINK'). $legacyPost->source_path) }} alt="{{$legacyPost->title}}"></a>
            <p>
                <a href = "{{ url('/images') }}" target = "blank">View Image Guidelines</a>
                {!! Form::file('image', null, ['class' => 'navButton']) !!}
            </p>
        </div>
    @else
        <div id = "centerTextContent">
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Express your idea or belief here:', 'rows' => '18%', 'maxlength' => '5000']) !!}
        </div>
    @endif

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>