@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">
    <h2>Update Support Request</h2>
    <div id = "createOptions">

        <div class = "formData">
            <div class = "formData">
                {!! Form::label('subject', 'Subject') !!}
            </div>
            <div class = "formData">
                {!! Form::text('subject', null, ['class' => 'createTitleText', 'autofocus']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formData">
                {!! Form::label('type', 'Type:') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('type', $types, null, ['class' => 'tagSelector']) !!}
            </div>
        </div>

        {!! Form::textarea('request', null, ['id' => 'createBodyText', 'placeholder' => 'What can we help with?', 'rows' => '3%', 'maxlength' => '300']) !!}

    </div>
    <!-- Body Form Input -->
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop
</div>