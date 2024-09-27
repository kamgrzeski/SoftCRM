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
                        <li class="active">
                            <a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <li class="">
                            <a href="#profile" data-toggle="tab">Tasks <span class="badge badge-warning">{{ $employee->taskCount }}</span></a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteEmployeeModal">
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
                                        <a href="{{ route('clients.view', $employee->client->id) }}">{{ $employee->client->full_name }}</a>
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
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($employee->tasks as $tasks)
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td>{{ $tasks->name }}</td>
                                        <td>
                                            <a class="btn btn-small btn-primary" href="{{ route('tasks.view',  $tasks->id) }}">More information</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('crm.employees.modals.delete_employee_modal')
@endsection
