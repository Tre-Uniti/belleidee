<div id = "createOptions">
    @if(isset($sources['post_id']))
        <p>Post Title: <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></p>
    @endif
    <div id = "centerTextContent">
        {!! Form::textarea('intolerance', null, ['id' => 'createBodyText', 'placeholder' => 'Why is this intolerant?:', 'rows' => '3%', 'maxlength' => '3500']) !!}
    </div>


<!-- Body Form Input -->

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

</div>