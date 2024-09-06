@extends('layouts.base')

@section('caption', 'Edit companies')

@section('title', 'Edit companies')

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
                            {{ Form::model($company, ['route' => ['companies.update', $company->id], 'method' => 'PUT']) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}

                            </div>

                            <div class="form-group">
                                {{ Form::label('tax_number', 'Tax number') }}
                                {{ Form::text('tax_number', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('phone', 'Phone') }}
                                {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('city', 'City') }}
                                {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('billing_address', 'Billing address') }}
                                {{ Form::text('billing_address', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('country', 'Country') }}
                                {{ Form::text('country', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('client_id', 'Assigned Client') }}
                                {{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')])  }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('postal_code', 'Postal code') }}
                                {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('employees_size', 'Employees size') }}
                                {{ Form::text('employees_size', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('fax', 'Fax') }}
                                {{ Form::text('fax', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('description', 'Description') }}
                                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.InputText')]) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            {{ Form::submit('Edit companies', ['class' => 'btn btn-primary']) }}
                        </div>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
