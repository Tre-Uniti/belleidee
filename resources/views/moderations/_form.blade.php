<div id = "createOptions">
    <h2>Moderation</h2>
    @if($intolerance->post_id != '')
        <p><a href = {{ action('PostController@show', [$intolerance->post_id])}}>Source Post</a></p>
    @elseif($intolerance->extension_id != '')
        <p><a href = {{ action('ExtensionController@show', [$intolerance->extension_id])}}>Source Extension</a></p>
    @endif

    <div id = "centerTextContent">
        <p>{{ $intolerance->user_ruling }}</p>
        {!! Form::textarea('mod_ruling', null, ['id' => 'createBodyText', 'placeholder' => 'Is this intolerant?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>
<!-- Body Form Input -->
    @section('centerFooter')
            {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>