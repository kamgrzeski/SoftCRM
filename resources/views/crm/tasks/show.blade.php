@extends('layouts.base')

@section('caption', 'Information about task: ' . $task->name)

@section('title', 'Information about task: ' . $task->name)

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            @include('layouts.template.messages')
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a></li>

                        @if(! $task->completed)
                            <a href="{{ URL::to('tasks/completed/' . $task->id . '/1') }}">
                                <button type="button" class="btn btn-success">Mark as completed</button>
                            </a>
                        @else
                            <a href="{{ URL::to('tasks/completed/' . $task->id . '/0') }}">
                                <button type="button" class="btn btn-success">Mark as uncompleted</button>
                            </a>
                        @endif
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteTaskModal">
                            Delete this task <li class="fa fa-trash-o"></li>
                        </button>
                    </ul>

                    <div class="tab-pane fade active in">
                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Name</th>
                                <td>{{ $task->name }}</td>
                            </tr>
                            <tr>
                                <th>Assigned employee</th>
                                <td>
                                    <a href="{{ URL::to('employees/view/' . $task->employees->id) }}">{{ $task->employees->full_name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ $task->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $task->is_active ? 'Active' : 'Deactivate' }}</td>
                            </tr>
                            <tr>
                                <th>Completed</th>
                                <td>{{ $task->completed ? 'Yes' : 'No' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('crm.tasks.modals.delete_task_modal')
@endsection
