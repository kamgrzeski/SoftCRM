@extends('layouts.base')

@section('caption', 'Edit empoloyees')

@section('title', 'Edit empoloyees')

@section('lyric', 'lorem ipsum')

@section('content')
    @if(session()->has('message_success'))
        <div class="alert alert-success">
            <strong>Well done!</strong> {{ session()->get('message_success') }}
        </div>
    @elseif(session()->has('message_danger'))
        <div class="alert alert-danger">
            <strong>Danger!</strong> {{ session()->get('message_danger') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Danger!</strong> {!! implode('', $errors->all('<div>:message</div>')) !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::model($employee, ['route' => ['employees.update', $employee->id], 'method' => 'PUT']) }}

                            <div class="form-group">
                                {{ Form::label('full_name', 'Full name') }}
                                {{ Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', 'Email address') }}
                                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('client_id', 'Assign client') }}
                                {{ Form::select('client_id', $clients->pluck('full_name', 'id'), null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')])  }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('phone', 'Phone') }}
                                {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('job', 'Job') }}
                                {{ Form::text('job', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('note', 'Notatnik') }}
                                {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            {{ Form::submit('Edit employee', ['class' => 'btn btn-primary']) }}
                        </div>

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
