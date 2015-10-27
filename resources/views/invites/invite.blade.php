@extends ('app')
@section('centerMenu')
    @if (count($errors) > 0)
        @include('errors.list')
    @endif
@stop
@section('centerText')

    <h1>Send Invites:</h1>
    {!! Form::open(['url' => 'invites']) !!}
        <table align = "center">
            <thead>
            <tr><th> {!! Form::label('to_Email', 'Email') !!}</th><th> {!! Form::label('betaToken', 'Beta-Token') !!}</th></tr>
            </thead>
            <tbody>
            <tr><td>{!! Form::text('to_email', null, ['class' => 'createAttributes', 'placeholder' => 'To whom?']) !!}</td>
                <td>{!! Form::text('betaToken', str_random(7), ['class' => 'createAttributes']) !!} </td>
            </tr>
            </tbody>
        </table>
    <div class = "createSubmit">
        {!! Form::submit('Send Invite', ['class' => 'navButton']) !!}
        {!! Form::close()   !!}
    </div>
@stop