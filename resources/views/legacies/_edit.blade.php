@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">
    <div class = "formData">
        {!! Form::label('belief', 'Belief Name:') !!}
        {!! Form::text('belief', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Which belief is this legacy for?']) !!}
    </div>
    <!-- Body Form Input -->
    <div id = "centerTextContent">
        {!! Form::label('handle', 'Legacy User:') !!}
        {!! Form::textarea('handle', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Which user (handle) can post?']) !!}
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>