@extends ('app')
@section('centerMenu')
    @if (count($errors) > 0)
        @include('errors.list')
    @endif
@stop
@section('centerText')

    <h1>Send Invites:</h1>
        <table align = "center">
            <thead>
            <tr><th> {!! Form::label('To_Email', 'Email') !!}</th><th> {!! Form::label('token', 'Token') !!}</th></tr>
            </thead>
            <tbody>
            <tr><td>{!! Form::text('to_Email', null, ['class' => 'createAttributes', 'placeholder' => 'To whom?']) !!}</td>
                <td>{!! Form::text('to_Email', str_random(7), ['class' => 'createAttributes']) !!} </td>
            </tr>
            </tbody>
        </table>
    <div class = "createSubmit">
        {!! Form::submit('Send Invite', ['class' => 'navButton']) !!}
    </div>
@stop