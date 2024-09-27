@extends('layouts.base')

@section('caption', 'List of tasks')

@section('title', 'List of tasks')

@section('lyric', '')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ route('tasks.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add tasks</button>
            </a>
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
                            @foreach($tasks->where('completed', 0) as $key => $task)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $task->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('employees.view',$task->employee->id) }}">{{ $task->employee->full_name }}</a>
                                        </td>
                                        <td class="text-right">{{ $task->duration . ' days' }}</td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('tasks.set.active', $task) }}">
                                            @csrf
                                                <label class="switch">
                                                    <input type="checkbox" onchange="this.form.submit()" @if($task->is_active) checked @endif>
                                                    <span class="slider"></span>
                                                </label>
                                            </form>
                                        </td>
                                        <td class="text-right">{{ $task->completed ? 'Yes' : 'No' }}</td>
                                        <td class="text-right">
                                            <form method="POST" action="{{ route('tasks.complete', $task) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-completed small-btn">Mark as completed</button>
                                            </form>
                                            <a class="btn btn-small btn-success small-btn" href="{{ route('tasks.view',  $task->id) }}">More information</a>
                                            <a class="btn btn-small btn-info small-btn" href="{{ route('tasks.update.form', $task->id) }}">Edit</a>
                                        </td>
                                    </tr>
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
                            @foreach($tasks->where('completed', true) as $key => $task)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $task->name }}</td>
                                        <td class="text-center">{{ $task->employee->full_name }}</td>
                                        <td class="text-right">
                                            <form method="POST" action="{{ route('tasks.complete', $task) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-completed small-btn">Mark as uncompleted</button>
                                            </form>
                                        </td>
                                    </tr>
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
