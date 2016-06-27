@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
@section('pageHeader')
    <script src = "/js/toggleSource.js"></script>
@stop
<div id = "createOptions">
    <h2>Intolerance</h2>
    <p><button type = "button" class = "interactButton" id = "content">Show Source</button></p>
    <div class = "extensionContent" id = "hiddenContent">
        @if($sources['post_id'] != null)
            @if($type != 'txt')
                <div class = "photoContent">
                    <a href = "{{ url('/posts/'. $sourceModel->id) }}" target = "_blank"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->post_path) }} alt="{{$sourceModel->title}}"></a>
                </div>
            @else
                {!! nl2br(e($content)) !!}
            @endif
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>
        @elseif($sources['extension_id'])
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
        {!! Form::textarea('user_ruling', null, ['id' => 'createBodyText', 'placeholder' => 'Why is this intolerant?:', 'rows' => '3%', 'maxlength' => '300']) !!}
    </div>
<!-- Body Form Input -->
    @section('centerFooter')
            {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>