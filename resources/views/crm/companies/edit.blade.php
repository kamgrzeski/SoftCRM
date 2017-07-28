@extends('layouts.base')

@section('caption', 'Edit companies')

@section('title', 'Edit companies')

@section('lyric', 'some text about edit companies')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Basic Form Elements
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">

                            {{ Form::model($companies, array('route' => array('companies.update', $companies->id), 'method' => 'PUT')) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('tags', 'Tags') }}
                                {{ Form::text('tags', null, array('class' => 'form-control')) }}
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('tax_number', 'Tax number') }}
                                {{ Form::text('tax_number', null, array('class' => 'form-control')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('is_active', 'Active') }}
                                {{ Form::checkbox('is_active', null, array('class' => 'form-control')) }}
                            </div>

                        </div>

                        <div class="col-lg-12">
                            {{ Form::submit('Submit Button', array('class' => 'btn btn-default')) }}
                            {{ Form::reset('Reset Button', array('class' => 'btn btn-default')) }}
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