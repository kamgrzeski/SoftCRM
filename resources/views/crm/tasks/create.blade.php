@extends('layouts.base')

@section('caption', 'Add tasks')

@section('title', 'Add tasks')

@section('lyric', 'lorem ipsum')

@section('content')
    @if(count($dataOfEmployees) == 0)
        <div class="alert alert-danger">
            <strong>Danger!</strong> There is no employees in system. Please create one. <a href="{{ URL::to('employees/create') }}">Click here!</a>
        </div>
    @endif
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
                        <div class="col-lg-6">
                            {{ Form::open(array('route' => 'processCreateTasks')) }}

                            <div class="form-group input-row">
                                {{ Form::label('name', 'Name') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                                    {{ Form::textarea('name', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('employee_id', 'Assign employees') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                                    {{ Form::select('employee_id', $dataOfEmployees, null, ['class' => 'form-control', 'placeholder' => $inputText]) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('duration', 'Duration') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                                    {{ Form::text('duration', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 validate_form">
                            {{ Form::submit('Add task', array('class' => 'btn btn-primary')) }}
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