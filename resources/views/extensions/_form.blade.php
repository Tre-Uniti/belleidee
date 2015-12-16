<div id = "createOptions">
    <p><b>Extending:</b><a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></p>
<table align = "center" style = "margin-bottom: 7px;">
        <tr>
        <td colspan="3" style = "border-color: #E8E8E8;">{!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
        </tr>
    <tr>
            <td colspan="3" style = "border-color: #E8E8E8;">
                {!! Form::select('index', $beliefs) !!}
                {!! Form::select('belief_beacon', $beacons) !!}
                {!! Form::select('index2', $types) !!}
            </td>
    </tr>
</table>


<!-- Body Form Input -->
    <div id = "centerTextContent">
    {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Continue your extension here:', 'rows' => '19%']) !!}
    </div>
    @section('centerFooter')
    {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
            <!-- Later Implementation<a href="{{ url('/drafts') }}"><button type = "button" class = "navButton">Save as draft</button></a>-->
    @stop
</div>