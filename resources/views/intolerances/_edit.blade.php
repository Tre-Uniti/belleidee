<div id = "createOptions">
    <h2>Intolerance</h2>
    @if($intolerance->post_id != '')
       <p><a href = {{ action('PostController@show', $intolerance->post_id)}}> Source Post</a></p>
    @elseif($intolerance->extension_id != '')
        <p><a href = {{ action('ExtensionController@show', $intolerance->extension_id)}}>Source Extension</a></p>
    @elseif($intolerance->question_id != '')
        <p><a href = {{ action('QuestionController@show', $intolerance->quesiton_id)}}>Source Question</a></p>
    @endif
    <div id = "centerTextContent">
        {!! Form::textarea('user_ruling', null, ['id' => 'createBodyText', 'placeholder' => 'Why is this intolerant?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>