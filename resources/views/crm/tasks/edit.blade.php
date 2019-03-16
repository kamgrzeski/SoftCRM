@extends('layouts.base')

@section('caption', 'Edit tasks')

@section('title', 'Edit tasks')

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
                            {{ Form::model($tasks, array('route' => array('processUpdateTasks', $tasks->id), 'method' => 'PUT')) }}
                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('duration', 'Duration') }}
                                {{ Form::text('duration', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('employee_id', 'Assign employee') }}
                                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 'placeholder' => $inputText])  }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            {{ Form::submit('Edit task', array('class' => 'btn btn-primary')) }}
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