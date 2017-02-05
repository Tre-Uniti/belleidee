@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
@stop

<div id = "createOptions">
    <div class = "formDataContainer">
    <div class = "formData">
        {!! Form::label('belief', 'Belief Name:') !!}
        {!! Form::text('belief', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Must be in Idee directory']) !!}
    </div>
        <div class = "formData">
        {!! Form::label('handle', 'Legacy User:') !!}
        {!! Form::text('handle', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Assigned User (Handle)']) !!}
        </div>
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>