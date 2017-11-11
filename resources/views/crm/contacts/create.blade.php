@extends('layouts.base')

@section('caption', 'Add contacts')

@section('title', 'Add contacts')

@section('lyric', 'lorem ipsum')

@section('content')
    @if(count($clients) == 0)
        <div class="alert alert-danger">
            <strong>Danger!</strong> There is no clients in system. Please create one. <a
                    href="{{ URL::to('client/create') }}">Click here!</a>
        </div>
    @endif
    @if(count($employees) == 0)
        <div class="alert alert-danger">
            <strong>Danger!</strong> There is no employees in system. Please create one. <a
                    href="{{ URL::to('employees/create') }}">Click here!</a>
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
                            {{ Form::open(array('url' => 'contacts')) }}
                            <div class="form-group">
                                {{ Form::label('client_id', 'Assign client') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                                    {{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'placeholder' => \App\Language::getMessage('messages.InputText')])  }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('employee_id', 'Assign employee') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                                    {{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 'placeholder' => \App\Language::getMessage('messages.InputText')])  }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('date', 'Date') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {{ Form::date('date', null, array('class' => 'form-control', 'required', 'placeholder' => \App\Language::getMessage('messages.InputText'))) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            {{ Form::submit('Add contact', array('class' => 'btn btn-primary')) }}
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