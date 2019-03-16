@extends('layouts.base')

@section('caption', 'Edit companies')

@section('title', 'Edit companies')

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
                            {{ Form::model($companies, array('route' => array('processUpdateCompanies', $companies->id), 'method' => 'PUT')) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}

                            </div>

                            <div class="form-group">
                                {{ Form::label('tax_number', 'Tax number') }}
                                {{ Form::text('tax_number', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('phone', 'Phone') }}
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('city', 'City') }}
                                {{ Form::text('city', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('billing_address', 'Billing address') }}
                                {{ Form::text('billing_address', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('country', 'Country') }}
                                {{ Form::text('country', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('client_id', 'Assigned Client') }}
                                {{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'placeholder' => $inputText])  }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('postal_code', 'Postal code') }}
                                {{ Form::text('postal_code', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('employees_size', 'Employees size') }}
                                {{ Form::text('employees_size', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('fax', 'Fax') }}
                                {{ Form::text('fax', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('description', 'Description') }}
                                {{ Form::textarea('description', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>

                        </div>

                        <div class="col-lg-12">
                            {{ Form::submit('Edit companies', array('class' => 'btn btn-primary')) }}
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