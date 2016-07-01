@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop

<div id = "createOptions">
        <div class = "formData">
                {!! Form::label('title', 'Title:') !!}
        </div>
        <div class = "formData">
                {!! Form::text('title', null, ['class' => 'createTitleText']) !!}
            </div>

        <div class = "formData">
        {!! Form::select('belief', $beliefs) !!}
        </div>

        <div class = "formData">
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Add legacy text (max: 1000 characters).', 'rows' => '7%', 'maxlength' => '1000']) !!}
        </div>
</div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
