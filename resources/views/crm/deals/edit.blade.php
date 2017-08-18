@extends('layouts.base')

@section('caption', 'Edytuj umowę')

@section('title', 'Edytuj umowę')

@section('lyric', 'lorem ipsum')

@section('content')
    <!-- will be used to show any messages -->
    @if(session()->has('message_success'))
        <div class="alert alert-success">
            <strong>Bardzo dobrze!</strong> {{ session()->get('message_success') }}
        </div>
    @elseif(session()->has('message_danger'))
        <div class="alert alert-danger">
            <strong>Uwaga!</strong> {{ session()->get('message_danger') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::model($deals, array('route' => array('deals.update', $deals->id), 'method' => 'PUT')) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Nazwa') }}
                                {{ Form::text('name', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('start_time', 'Data rozpoczecia umowy') }}
                                {{ Form::date('start_time', null, array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('end_time', 'Data zakończenia umowy') }}
                                {{ Form::date('end_time', null, array('class' => 'form-control')) }}
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12">
                        {{ Form::submit('Submit Button', array('class' => 'btn btn-primary')) }}
                        {{ Form::reset('Reset Button', array('class' => 'btn btn-warning')) }}
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