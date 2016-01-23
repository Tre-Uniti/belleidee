<div id = "createOptions">
    <h2>Moderation</h2>
    @if(isset($sources['post_id']))
        <p>Post Title: <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></p>
    @elseif(isset($sources['extension_id']))
        <p>Extension Title: <a href = {{ action('ExtensionController@show', [$sources['extension_id']])}}> {{ $sources['extension_title'] }}</a></p>
    @endif

    <div id = "centerTextContent">
        <p>{{$intolerance}}</p>
        {!! Form::textarea('mod_ruling', null, ['id' => 'createBodyText', 'placeholder' => 'Why is this intolerant?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>
<!-- Body Form Input -->
    @section('centerFooter')
            {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>