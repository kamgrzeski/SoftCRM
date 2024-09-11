@extends('layouts.base')

@section('caption', 'Password change')

@section('title', 'Password change')

@section('content')
    @include('layouts.template.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        @include('crm.auth.passwords.forms.reset_password_form')
                    </div>
                </div>
            </div>
        </div>
@endsection
