@extends('layouts.base')

@section('caption', 'Dodaj spotkanie')

@section('title', 'Dodaj spotkanie')

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

    <!-- /. ROW  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::open(array('url' => 'contacts')) }}

                            <div class="form-group">
                                {{ Form::label('client_id', 'Klient') }}
                                {{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'required'])  }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('employee_id', 'Pracownik') }}
                                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 'required'])  }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('date', 'Data') }}
                                {{ Form::date('date', null, array('class' => 'form-control')) }}
                            </div>

                        </div>

                        <div class="col-lg-12">
                            {{ Form::submit('Submit Button', array('class' => 'btn btn-primary')) }}
                            {{ Form::reset('Reset Button', array('class' => 'btn btn-warning')) }}
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