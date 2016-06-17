@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
@section('title')
    Edit Belief
@stop
<div id = "createOptions">
    <div class = "formData">
        {!! Form::label('description', 'Description:') !!}
        {!! Form::text('description', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Description']) !!}
    </div>
    <!-- Body Form Input -->
    <div id = "centerTextContent">
        {!! Form::textarea('promo', null, ['id' => 'createBodyText', 'placeholder' => 'Promotion:', 'rows' => '3%', 'maxlength' => '255']) !!}
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>