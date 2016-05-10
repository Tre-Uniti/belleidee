<div id = "createOptions">
    <h2>Support Request</h2>
    <div id = "createOptions">
        {!! Form::label('type', 'Type:') !!}
        {!! Form::select('type', $types) !!}
        {!! Form::textarea('request', $support->request, ['id' => 'createBodyText', 'placeholder' => 'What can we help with?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>
    <!-- Body Form Input -->
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop
</div>