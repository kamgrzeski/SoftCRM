@extends('layouts.base')

@section('caption', 'Add companies')

@section('title', 'Add companies')

@section('lyric', 'some text about add companies')

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

                            {{ Form::open(array('url' => 'companies')) }}

                                <div class="form-group">
                                    {{ Form::label('name', 'Name') }}
                                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                                </div>

                            <div class="form-group">
                                {{ Form::label('tax_number', 'Tax Number') }}
                                {{ Form::text('tax_number', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('tags', 'Tags') }}
                                {{ Form::text('tags', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('city', 'City') }}
                                {{ Form::text('city', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('billing_address', 'Billing Address') }}
                                {{ Form::text('billing_address', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('state', 'State') }}
                                {{ Form::text('state', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('country', 'country') }}
                                {{ Form::text('country', null, array('class' => 'form-control')) }}
                            </div>

                        </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('postal_code', 'Postal Code') }}
                                        {{ Form::text('postal_code', null, array('class' => 'form-control')) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('employees', 'Employees') }}
                                        {{ Form::text('employees', null, array('class' => 'form-control')) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('fax', 'Fax') }}
                                        {{ Form::text('fax', null, array('class' => 'form-control')) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('description', 'Description') }}
                                        {{ Form::textarea('description', null, array('class' => 'form-control')) }}
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