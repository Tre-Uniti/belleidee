@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
    <script src = "/js/toggleSource.js"></script>
@stop
<div id = "createOptions">
    <h2>Intolerance</h2>
    <p><button type = "button" class = "interactButton" id = "content">Show Source</button></p>
    <div class = "extensionContent" id = "hiddenContent">
        @if($intolerance->post_id != null)
            @if($type != 'txt')
                <div class = "photoContent">
                    <a href = "{{ url('/posts/'. $sourceModel->id) }}" target = "_blank"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->post_path) }} alt="{{$sourceModel->title}}"></a>
                </div>
            @else
                {!! nl2br(e($content)) !!}
            @endif
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>
        @elseif($intolerance->extension_id != null)
            @if($type != 'txt')
                <div class = "photoContent">
                    <a href = "{{ url('/extensions/'. $sourceModel->id) }}" target = "_blank"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->extension_path) }} alt="{{$sourceModel->title}}"></a>
                </div>
            @else
                {!! nl2br(e($content)) !!}
            @endif
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>
        @endif
    </div>
    <div id = "centerTextContent">
        <p class = "centered">Submitted for {{ $intolerance->user_ruling }} (<a href = "{{ url('/users/'. $intolerance->user_id) }}" target = "_blank">{{ $intolerance->user->handle }})</a></p>
        <p>{{ $moderation->mod_ruling }} (<a href = "{{ url('users/' . $moderation->user_id) }}" target = "_blank">{{ $moderation->user->handle }})</a></p>
        {!! Form::textarea('admin_ruling', null, ['id' => 'createBodyText', 'placeholder' => 'Is this intolerant?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>
    <!-- Body Form Input -->

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>