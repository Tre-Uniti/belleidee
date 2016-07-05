@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop

<div id = "createOptions">
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('title', 'Title') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('title', null, ['class' => 'createFormText', 'autofocus', 'placeholder' => 'Title of Announcement']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formData">
            {!! Form::textarea('description', null, ['id' => 'createBodyText', 'placeholder' => 'Description about the announcement.', 'rows' => '3%', 'maxlength' => '255']) !!}
        </div>
    </div>
    {!! Form::hidden('beacon_id', $beacon->id) !!}
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>