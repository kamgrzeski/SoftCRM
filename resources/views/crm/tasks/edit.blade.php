@extends('layouts.base')

@section('caption', 'Edit tasks')

@section('title', 'Edit tasks')

@section('lyric', 'lorem ipsum')

@section('content')
    @include('layouts.template.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @include('crm.tasks.forms.update_task_form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
