@section('pageHeader')
    <script src = "/js/toggleSource.js"></script>
@stop
<div id = "createOptions">
    <h2>Intolerance</h2>
    @if(isset($sources['post_id']))
        <p><button type = "button" class = "interactButton" id = "content">Show Source Text</button></p>
        <div class = "extensionContent" id = "hiddenContent">{!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p></div>
    @elseif(isset($sources['extension_id']))
        <p><button type = "button" class = "interactButton" id = "content">Show Source Text</button></p>
        <div class = "extensionContent" id = "hiddenContent">{!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p></div>
    @endif
        <div id = "centerTextContent">
        {!! Form::textarea('user_ruling', null, ['id' => 'createBodyText', 'placeholder' => 'Why is this intolerant?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>
<!-- Body Form Input -->
    @section('centerFooter')
            {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>