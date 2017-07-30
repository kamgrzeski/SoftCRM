@extends('layouts.base')

@section('caption', 'Add companies')

@section('title', 'Add companies')

@section('lyric', 'some text about add companies')

@section('content')
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-warning">{{ Session::get('message') }}</div>
    @endif

    <!-- /. ROW  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Basic Form Elements
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">

                            {{ Form::open(array('url' => 'companies')) }}

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