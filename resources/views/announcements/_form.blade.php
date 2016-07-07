@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop

<div id = "createOptions">
<p>Announcements are posted on your home page as well as sent to users who recently used your beacon tag.</p>
    <div class = "formData">
        {!! Form::label('title', 'Title:') !!}
    </div>
    <div class="formData">
        {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => '']) !!}
    </div>

    <div class = "formData">
        {!! Form::textarea('description', null, ['id' => 'createBodyText', 'placeholder' => 'Description about the announcement.', 'rows' => '3%', 'maxlength' => '255']) !!}
    </div>
    {!! Form::hidden('beacon_id', $beacon->id) !!}
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>