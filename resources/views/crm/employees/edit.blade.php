@extends('layouts.base')

@section('caption', 'Edit employees')

@section('title', 'Edit employees')

@section('lyric', 'lorem ipsum')

@section('content')

    @include('layouts.template.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('crm.employees.forms.update_employee')
                </div>
            </div>
        </div>
    </div>
@endsection
