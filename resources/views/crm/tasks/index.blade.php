@extends('layouts.base')

@section('caption', 'List of tasks')

@section('title', 'List of tasks')

@section('lyric', '')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ URL::to('tasks/form/create') }}">
                <button type="button" class="btn btn-primary btn active">Add tasks</button>
            </a>
            <br>
            <h4 class="page-header">
                <i class="fa fa-code-fork" aria-hidden="true"></i> List of uncompleted tasks
            </h4>
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Assigned employee</th>
                                <th class="text-center">Duration</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Completed</th>
                                <th class="text-center" style="width:300px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $key => $value)
                                @if($value->completed == 0)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $value->name }}</td>
                                        <td class="text-center"><a
                                                    href="{{ URL::to('employees/view/' . $value->employees->id) }}">{{ $value->employees->full_name }}</a>
                                        </td>
                                        <td class="text-right">{{ $value->duration . ' days' }}</td>
                                        <td class="text-center">
                                                @if($value->is_active)
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                               onchange='window.location.assign("{{ URL::to('tasks/set-active/' . $value->id . '/0') }}")' checked>
                                                        <span class="slider"></span>
                                                    </label>
                                                @else
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                               onchange='window.location.assign("{{ URL::to('tasks/set-active/' . $value->id . '/1') }}")'>
                                                        <span class="slider"></span>
                                                    </label>
                                                @endif
                                        </td>
                                        <td class="text-right">{{ $value->completed ? 'Yes' : 'No' }}</td>
                                        <td class="text-right">
                                            @if($value->completed == FALSE)
                                                <a href="{{ URL::to('tasks/completed/' . $value->id . '/1') }}">
                                                    <button type="button" class="btn btn-completed small-btn">Mark as completed</button>
                                                </a>
                                            @else
                                                <a href="{{ URL::to('tasks/completed/' . $value->id . '/0') }}">
                                                    <button type="button" class="btn btn-completed small-btn">Mark as uncompleted</button>
                                                </a>
                                            @endif
                                            <a class="btn btn-small btn-success small-btn"
                                               href="{{ URL::to('tasks/view/' . $value->id) }}">More information</a>
                                            <a class="btn btn-small btn-info small-btn"
                                               href="{{ URL::to('tasks/form/update/' . $value->id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $tasks->render() !!}
                </div>
            </div>

            <h4 class="page-header">
                <i class="fa fa-code-fork" aria-hidden="true"></i> List of completed tasks
            </h4>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table" style="color: grey;">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Assigned employee</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $key => $task)
                                @if($task->completed)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $task->name }}</td>
                                        <td class="text-center">{{ $task->employees->full_name }}</td>
                                        <td class="text-right">
                                            @if(! $task->completed)
                                                <a href="{{ URL::to('tasks/completed/' . $task->id . '/1') }}">
                                                    <button type="button" class="btn btn-completed small-btn" style="background-color: grey !important; border-color: grey">Mark as completed</button>
                                                </a>
                                            @else
                                                <a href="{{ URL::to('tasks/completed/' . $task->id . '/0') }}">
                                                    <button type="button" class="btn btn-completed small-btn" style="background-color: grey !important; border-color: grey">Mark as uncompleted</button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $tasks->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
