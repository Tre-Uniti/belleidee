@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
@section('title')
    Edit Belief
@stop
<div id = "createOptions">
    <div class = "formData">
        <div id = "centerTextContent">
            {!! Form::textarea('description', null, ['id' => 'createBodyText', 'placeholder' => 'Description of Promotion:', 'rows' => '3%', 'maxlength' => '255']) !!}
        </div>
        {!! Form::label('promo', 'Promo Code:') !!}
        {!! Form::text('promo', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Enter code here...']) !!}
    </div>
    <!-- Body Form Input -->

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>