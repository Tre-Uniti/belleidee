@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop

<div id = "createOptions">
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('promo', 'Promo Code:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('promo', null, ['class' => 'createFormText', 'autofocus', 'placeholder' => 'Enter code here']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('status', 'Status:') !!}
        </div>
        <div class = "formInput">
            {!! Form::select('status', $statuses) !!}
        </div>
        <div class = "formData">
            {!! Form::textarea('description', null, ['id' => 'createBodyText', 'placeholder' => 'Description about the promo and how to use it.', 'rows' => '3%', 'maxlength' => '255']) !!}
        </div>
    </div>
    <!-- Body Form Input -->
        {!! Form::hidden('sponsor_id', $sponsor->id) !!}
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>