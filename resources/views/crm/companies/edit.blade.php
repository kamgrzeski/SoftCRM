@extends('layouts.base')

@section('caption', 'Edit companies')

@section('title', 'Edit companies')

@section('lyric', 'lorem ipsum')

@section('content')

    @include('layouts.template.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('crm.companies.forms.update_company_form')
                </div>
            </div>
        </div>
    </div>
@endsection
