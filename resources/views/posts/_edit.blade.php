@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/creation.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">
    <div class = "formInput">
        {!! Form::label('title', 'Post Title:', ['class' => 'tagLabel']) !!}
    </div>
     <div class = "formData">
            {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
     </div>
    </div>

    <!-- Body Form Input -->
    @if($type != 'txt')
        <div class = "photoContent">
            {!! Form::textarea('caption', null, ['id' => 'createBodyText', 'placeholder' => 'Add optional caption:', 'rows' => '2%', 'maxlength' => '255']) !!}
            <a href={{ url('/posts/'. $post->id) }}><img src= {{ url(env('IMAGE_LINK'). $post->post_path) }} alt="{{$post->title}}"></a>
            <p>
                <a href = "{{ url('/images') }}" target = "blank">View Image Guidelines</a>
            {!! Form::file('image', null, ['class' => 'navButton']) !!}
            </p>
        </div>
    @else
        <div id = "centerTextContent">
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Express your idea or belief here:', 'rows' => '18%', 'maxlength' => '5000']) !!}
        </div>
    @endif

<div class = "indexContent" id = "hiddenIndexContent">
    <div class = "formData">
        <div class = "formCreation">
            <div class = "tagLabel">Belief or Way:</div>
            <div>
                <select name = 'belief' required >
                    <option value="Adaptia" @if (old('belief') == 'Adaptia') selected="selected" @elseif($post->belief == 'Adaptia' & (old('belief') == '')) selected="selected" @endif>Adaptia</option>
                    <option value="Atheism" @if (old('belief') == 'Atheism') selected="selected" @elseif($post->belief == 'Atheism' & (old('belief') == '')) selected="selected" @endif>Atheism</option>
                    <option value="Bahá’í" @if (old('belief') == 'Bahá’í') selected="selected" @elseif($post->belief == 'Bahá’í' & (old('belief') == '')) selected="selected" @endif>Bahá’í</option>
                    <option value="Buddhism" @if (old('belief') == 'Buddhism') selected="selected" @elseif($post->belief == 'Buddhism' & (old('belief') == '')) selected="selected" @endif>Buddhism</option>
                    <option value="Christianity" @if (old('belief') == 'Christianity') selected="selected" @elseif($post->belief == 'Christianity' & (old('belief') == '')) selected="selected" @endif>Christianity</option>
                    <option value="Druze" @if (old('belief') == 'Druze') selected="selected" @elseif($post->belief == 'Druze' & (old('belief') == '')) selected="selected" @endif>Druze</option>
                    <option value="Hinduism" @if (old('belief') == 'Hinduism') selected="selected" @elseif($post->belief == 'Hinduism' & (old('belief') == '')) selected="selected" @endif>Hinduism</option>
                    <option value="Islam" @if (old('belief') == 'Islam') selected="selected" @elseif($post->belief == 'Islam' & (old('belief') == '')) selected="selected" @endif>Islam</option>
                    <option value="Indigenous" @if (old('belief') == 'Indigenous') selected="selected" @elseif($post->belief == 'Indigenous' & (old('belief') == '')) selected="selected" @endif>Indigenous</option>
                    <option value="Jainism" @if (old('belief') == 'Jainism') selected="selected" @elseif($post->belief == 'Jainism' & (old('belief') == '')) selected="selected" @endif>Jainism</option>
                    <option value="Judaism" @if (old('belief') == 'Judaism') selected="selected" @elseif($post->belief == 'Judaism' & (old('belief') == '')) selected="selected" @endif>Judaism</option>
                    <option value="Shinto" @if (old('belief') == 'Shinto') selected="selected" @elseif($post->belief == 'Shinto' & (old('belief') == '')) selected="selected" @endif>Shinto</option>
                    <option value="Sikhism" @if (old('belief') == 'Sikhism') selected="selected" @elseif($post->belief == 'Sikhism' & (old('belief') == '')) selected="selected" @endif>Sikhism</option>
                    <option value="Taoism" @if (old('belief') == 'Taoism') selected="selected" @elseif($post->belief == 'Taoism'& (old('belief') == '')) selected="selected" @endif>Taoism</option>
                    <option value="Urantia" @if (old('belief') == 'Urantia') selected="selected" @elseif($post->belief == 'Urantia' & (old('belief') == '')) selected="selected" @endif>Urantia</option>
                    <option value="Zoroastrianism" @if (old('belief') == 'Zoroastrianism') selected="selected" @elseif($post->belief == 'Zoroastrianism' & (old('belief') == '')) selected="selected" @endif>Zoroastrianism</option>
                    <option value="Other" @if (old('belief') == 'Other') selected="selected" @elseif($post->belief == 'Other' & (old('belief') == '')) selected="selected" @endif>Other</option>
                </select>
            </div>
        </div>
        <div class = "formCreation">
            <div class = "tagLabel">Beacon Tag:</div>
            <div>
                {!! Form::select('beacon_tag', $beacons) !!}
            </div>
        </div>
        <div class = "formCreation">
            <div class = "tagLabel">Source:</div>
            <div>
                <select name = 'source' required>
                    <option value="Discussion" @if (old('source') == 'Discussion') selected="selected" @elseif($post->source == 'Discussion' & (old('Discussion') == '')) selected="selected"  @endif>Discussion</option>
                    <option value="Reflection" @if (old('source') == 'Reflection') selected="selected" @elseif($post->source == 'Reflection' & (old('Reflection') == '')) selected="selected"  @endif>Reflection</option>
                    <option value="Writings" @if (old('source') == 'Writings') selected="selected" @elseif($post->source == 'Writings' & (old('category') == '')) selected="selected"  @endif>Writings</option>
                    <option value="Nature" @if (old('source') == 'Nature') selected="selected" @elseif($post->source == 'Nature' & (old('category') == '')) selected="selected"  @endif>Nature</option>
                    <option value="Other" @if (old('source') == 'Other') selected="selected" @elseif($post->source == 'Other' & (old('category') == '')) selected="selected"  @endif>Other</option>
                </select>
            </div>
        </div>
    </div>
    @section('centerFooter')
        <button class = "interactButton" type = "button" id = "hiddenIndex">Tags</button>
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "interactButton">Cancel</button></a>
    @stop
</div>