@extends('layouts.base')

@section('caption', 'Edit empoloyees')

@section('title', 'Edit empoloyees')

@section('lyric', 'lorem ipsum')

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
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::model($employees, array('route' => array('processUpdateEmployee', $employees->id), 'method' => 'PUT')) }}

                            <div class="form-group">
                                {{ Form::label('full_name', 'Full name') }}
                                {{ Form::text('full_name', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', 'Email address') }}
                                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('client_id', 'Assign client') }}
                                {{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'placeholder' => $inputText])  }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('phone', 'Phone') }}
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('job', 'Job') }}
                                {{ Form::text('job', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('note', 'Notatnik') }}
                                {{ Form::textarea('note', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            {{ Form::submit('Edit employee', array('class' => 'btn btn-primary')) }}
                        </div>

                        {{ Form::close() }}

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>


@endsection