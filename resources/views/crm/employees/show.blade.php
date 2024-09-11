@extends('layouts.base')

@section('caption', 'Information about employees')

@section('title', 'Information about employees')

@section('lyric', '')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            @include('layouts.template.messages')
            <div class="panel panel-default">
                <div class="panel-heading">
                    More information about: {{ $employee->full_name }}
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Tasks <span
                                        class="badge badge-warning">{{ $employee->taskCount }}</span></a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                Delete this employee <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">


                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Full name</th>
                                    <td>{{ $employee->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $employee->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email address</th>
                                    <td>{{ $employee->email }}</td>
                                </tr>
                                <tr>
                                    <th>Job</th>
                                    <td>{{ $employee->job }}</td>
                                </tr>
                                <tr>
                                    <th>Note</th>
                                    <td>{{ $employee->note }}</td>
                                </tr>
                                <tr>
                                    <th>Assigned client</th>
                                    <td>
                                        <a href="{{ URL::to('clients/view/' . $employee->client->id) }}">{{ $employee->client->full_name }}</a>
                                    </td>

                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $employee->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <br>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                </tr>
                                @foreach($employee->tasks as $tasks)
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td>{{ $tasks->name }}</td>
                                        <td>
                                            <a class="btn btn-small btn-primary" href="{{ URL::to('tasks/view/' . $tasks->id) }}">More information</a>
                                        </td>
                                    @endforeach
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
                    <h4 class="modal-title" id="myModalLabel">You want delete this employee?</h4>
                </div>
                <div class="modal-body">
                    Action will delete permanently this employees.
                </div>
                <div class="modal-footer">
                    @include('crm.employees.forms.delete_employee')
                </div>
            </div>
        </div>
    </div>
@endsection
