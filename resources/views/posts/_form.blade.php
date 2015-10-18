<div class = "createTitle">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'createTitleText']) !!}
    <p>Today's Date: 10-17-2015</p>
    <table align = "center">
     <thead>
     <tr><th> {!! Form::label('index', 'Indexer') !!}</th>
         <th>{!! Form::label('beacon', 'Beacon') !!}</th>
         <th>{!! Form::label('index2', 'Indexer') !!}</th>
     </thead>
        <tbody>
        <tr><td>{!! Form::text('index', null, ['class' => 'createAttributes']) !!}</td>
        <td>{!! Form::text('beacon', null, ['class' => 'createAttributes']) !!}</td>
        <td>{!! Form::text('index2', null, ['class' => 'createAttributes']) !!}</td></tr>
        </tbody>
    </table>

</div>
<!-- Body Form Input -->

<div class="createBody">
    {!! Form::textarea('body', null, ['class' => 'createBodyText', 'placeholder' => 'Express your belief here:']) !!}
</div>
<div class = "createSubmit">
    {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
</div>