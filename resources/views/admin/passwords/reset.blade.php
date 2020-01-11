@extends('layouts.base')

@section('caption', 'Password change')

@section('title', 'Password change')

@section('content')
    <!-- will be used to show any messages -->
    @if(session()->has('message_success'))
        <div class="alert alert-success">
            <strong>Well done!</strong> {{ session()->get('message_success') }}
        </div>
    @elseif(session()->has('message_danger'))
        <div class="alert alert-danger">
            <strong>Danger!</strong> {{ session()->get('message_danger') }}
        </div>
    @endif

    <!-- /. ROW  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        {{ Form::open(['route' => 'password-process']) }}
                        <div class="col-lg-12">
                            <div class="form-group input-row">
                                {{ Form::label('old_password', 'Old password') }}
                                {{ Form::password('old_password', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group input-row">
                                {{ Form::label('new_password', 'New password') }}
                                {{ Form::password('new_password', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group input-row">
                                {{ Form::label('confirm_password', 'Repeat new password') }}
                                {{ Form::password('confirm_password', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-12 validate_form">
                            {{ Form::submit('Change password', ['class' => 'btn btn-primary']) }}
                        </div>
                    {{ Form::close() }}
                    <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
@endsection
