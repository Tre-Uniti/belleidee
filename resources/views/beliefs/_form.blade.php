@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop

<div class = "formDataContainer">
    <div class = "formData">
        {!! Form::label('name', 'Belief Name:') !!}
        {!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Belief Name']) !!}
    </div>
<!-- Body Form Input -->
    <div id = "centerTextContent">
        <div class = "formLabel">Description</div>
        {!! Form::textarea('description', null, ['id' => 'createBodyText', 'placeholder' => 'Description of belief:', 'rows' => '5%', 'maxlength' => '1000']) !!}
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('Max Upload size: 10MB') !!}
        </div>
        <div class = "formInput">
            {!! Form::file('image', null, ['class' => 'navButton']) !!}
        </div>
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>