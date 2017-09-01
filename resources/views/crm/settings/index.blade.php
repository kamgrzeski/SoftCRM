@extends('layouts.base')

@section('caption', 'Add client')

@section('title', 'Add client')

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
                            {{ Form::open(array('url' => 'settings')) }}
                            <div class="form-group">
                                {{ Form::label('pagination_size', 'Pagination Size') }}
                                {{ Form::text('pagination_size', config('crm_settings.pagination_size'), array('class' => 'form-control')) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('currency', 'Currency') }}
                                {{ Form::select('currency', ['PLN' => 'PLN', 'EUR' => 'EUR', 'USD' => 'USD'], config('crm_settings.currency'), ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            {{ Form::submit('Submit Button', array('class' => 'btn btn-primary')) }}
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
