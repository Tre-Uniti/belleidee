@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">
    <h2>New Community Question</h2>
    <div class = "formDataContainer">

    <div class = "formLabel">
        {!! Form::label('title', 'Community Question') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('question', null, ['class' => 'createFormText', 'autofocus']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('user_id', 'User ID') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('user_id', null, ['class' => 'createFormText']) !!}
    </div>
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop
</div>