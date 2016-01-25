<div id = "createOptions">
    <h2>Intolerance</h2>
    @if($moderation->post_id != '')
       <p><a href = {{ action('PostController@show', $moderation->post_id)}}> Source Post</a></p>
    @elseif($moderation->extension_id != '')
        <p><a href = {{ action('ExtensionController@show', $moderation->extension_id)}}>Source Extension</a></p>
    @elseif($moderation->question_id != '')
        <p><a href = {{ action('QuestionController@show', $moderation->quesiton_id)}}>Source Question</a></p>
    @endif
    <div id = "centerTextContent">
        <p>{{ $intolerance->user_ruling }}</p>
        <p>{{ $moderation->mod_ruling }}</p>
        {!! Form::textarea('admin_ruling', null, ['id' => 'createBodyText', 'placeholder' => 'Is this intolerant?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>
    <!-- Body Form Input -->

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>