@extends('layouts.base')

@section('caption', 'Dodaj firmę')

@section('title', 'Dodaj firmę')

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

    <!-- /. ROW  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::open(array('url' => 'employees')) }}

                            <div class="form-group">
                                {{ Form::label('full_name', 'Imie i nazwisko') }}
                                {{ Form::text('full_name', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('phone', 'Telefon') }}
                                {{ Form::text('phone', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('email', 'Email') }}
                                {{ Form::text('email', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('job', 'Stanowisko') }}
                                {{ Form::text('job', null, array('class' => 'form-control')) }}
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="form-group">
                                {{ Form::label('companies_id', 'Firma') }}
                                {{ Form::select('companies_id', $employees, null, ['class' => 'form-control'])  }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('note', 'Notatnik') }}
                                {{ Form::textarea('note', null, array('class' => 'form-control')) }}
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