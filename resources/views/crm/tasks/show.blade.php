@extends('layouts.base')

@section('caption', 'Information about task: ' . $task->name)

@section('title', 'Information about task: ' . $task->name)


@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            <!-- will be used to show any messages -->
            @if(session()->has('message_success'))
                <div class="alert alert-success">
                    <strong>Well done!</strong> {{ session()->get('message_success') }}
                </div>
            @elseif(session()->has('message_danger'))
                <div class="alert alert-danger">
                    <strong>Danger!</strong> {{ session()->get('message_danger') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                        </li>

                        <div class="text-right">
                                @if($task->completed == FALSE)
                                    <a href="{{ URL::to('tasks/completed/' . $task->id) }}">
                                        <button type="button" class="btn btn-success">Mark as completed</button>
                                    </a>
                                @else
                                    <a href="{{ URL::to('tasks/uncompleted/' . $task->id) }}">
                                        <button type="button" class="btn btn-success">Mark as uncompleted</button>
                                    </a>
                                @endif
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                        Delete this task <li class="fa fa-trash-o"></li>
                                    </button>
                        </div>

                    </ul>
                    <div class="tab-pane fade active in" id="home">
                        <h4></h4>

                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Name</th>
                                <td>{{ $task->name }}</td>
                            </tr>
                            <tr>
                                <th>Assigned employee</th>
                                <td><a
                                            href="{{ URL::to('employees/view/' . $task->employees->id) }}">{{ $task->employees->full_name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ $task->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $task->is_active ? 'Active' : 'Deactive' }}</td>
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
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">You want delete this task?</h4>
                </div>
                <div class="modal-body">
                    Ation will delete permanently this task.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 15px;">Close</button>
                    {{ Form::open(['url' => 'tasks/delete/' . $task->id,'class' => 'pull-right']) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete this task', ['class' => 'btn btn-small btn-danger']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection