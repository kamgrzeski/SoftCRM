@extends('layouts.base')

@section('caption', 'Dodaj umowę')

@section('title', 'Dodaj umowę')

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
                            {{ Form::open(array('url' => 'deals')) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Nazwa') }}
                                {{ Form::text('name', null, array('class' => 'form-control', 'required')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('start_time', 'start_time') }}
                                {{ Form::date('start_time', null, array('class' => 'form-control', 'required')) }}
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="form-group">
                                {{ Form::label('end_time', 'end_time') }}
                                {{ Form::date('end_time', null, array('class' => 'form-control', 'required')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('companies_id', 'Umowa między firmą:') }}
                                {{ Form::select('companies_id', $deals, null, ['class' => 'form-control', 'required'])  }}

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