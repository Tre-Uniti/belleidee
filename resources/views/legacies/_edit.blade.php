@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">
    <div class = "formDataContainer">
        <div class = "formLabel">
            {!! Form::label('belief', 'Belief Name:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('belief', $legacy->belief->name, ['class' => 'infoTitleText', 'autofocus', 'placeholder' => 'Must be in Idee directory']) !!}
        </div>
        <div class = "formLabel">
            {!! Form::label('handle', 'Legacy User:') !!}
        </div>
        <div class = "formInput">

            {!! Form::text('handle', $legacy->user->handle, ['class' => 'infoTitleText', 'placeholder' => 'Assigned User (Handle)']) !!}
        </div>
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>