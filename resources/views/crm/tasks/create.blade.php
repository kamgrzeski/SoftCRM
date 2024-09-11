@extends('layouts.base')

@section('caption', 'Add tasks')

@section('title', 'Add tasks')

@section('lyric', 'lorem ipsum')

@section('content')
    @if(count($employees) == 0)
        <div class="alert alert-danger">
            <strong>Danger!</strong> There is no employees in system. Please create one. <a href="{{ URL::to('employees/create') }}">Click here!</a>
        </div>
    @endif

    @include('layouts.template.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @include('crm.tasks.forms.store_task_form')
                    </div>
                </div>
            </div>
        </div>
@endsection
