@extends('layouts.base')

@section('caption', 'Edit client')

@section('title', 'Edit client')

@section('lyric', '')

@section('content')

    @include('layouts.template.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('crm.clients.forms.update_client_form')
                </div>
            </div>
        </div>
    </div>
@endsection
