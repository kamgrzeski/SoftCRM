@extends('layouts.base')

@section('caption', 'Edit companies')

@section('title', 'Edit companies')

@section('lyric', 'lorem ipsum')

@section('content')

    @include('layouts.template.errors')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::model($company, ['route' => ['companies.update', $company->id], 'method' => 'PUT']) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}

                            </div>

                            <div class="form-group">
                                {{ Form::label('tax_number', 'Tax number') }}
                                {{ Form::text('tax_number', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('phone', 'Phone') }}
                                {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('city', 'City') }}
                                {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('billing_address', 'Billing address') }}
                                {{ Form::text('billing_address', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('country', 'Country') }}
                                {{ Form::text('country', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('client_id', 'Assigned Client') }}
                                {{ Form::select('client_id', $clients->pluck('full_name', 'id'), null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')])  }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('postal_code', 'Postal code') }}
                                {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('employees_size', 'Employees size') }}
                                {{ Form::text('employees_size', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('fax', 'Fax') }}
                                {{ Form::text('fax', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('description', 'Description') }}
                                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => App\Traits\Language::getMessage('messages.input_text')]) }}
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
