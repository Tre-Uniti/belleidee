@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop

<div id = "createOptions">
    <div class = "formData">
        {!! Form::label('name', 'Belief Name:') !!}
        {!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Title']) !!}
    </div>
<!-- Body Form Input -->
    <div id = "centerTextContent">
        {!! Form::textarea('description', null, ['id' => 'createBodyText', 'placeholder' => 'Description of belief:', 'rows' => '3%', 'maxlength' => '255']) !!}
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>