@extends('layouts.base')

@section('caption', 'Edit contacts')

@section('title', 'Edit contacts')

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
                            {{ Form::model($contacts, array('route' => array('contacts.update', $contacts->id), 'method' => 'PUT')) }}

                            <div class="form-group input-row">
                                {{ Form::label('client_id', 'Klient:') }}
                                {{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'placeholder' => \App\Models\Language::getMessage('messages.InputText')])  }}
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('employee_id', 'Assign employee:') }}
                                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 'placeholder' => \App\Models\Language::getMessage('messages.InputText')])  }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('date', 'Date') }}
                                {{ Form::date('date', null, array('class' => 'form-control', 'placeholder' => \App\Models\Language::getMessage('messages.InputText'))) }}
                            </div>

                        </div>

                        <div class="col-lg-12">
                            {{ Form::submit('Edit contact', array('class' => 'btn btn-primary')) }}
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