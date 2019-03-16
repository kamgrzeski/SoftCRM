@extends('layouts.base')

@section('caption', 'Information about client: ' . $clients->full_name)

@section('title', 'Information about client: ' . $clients->full_name)


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
            <br/>
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Assigned companies <span
                                        class="badge badge-warning">{{ $clients->companiesCount }}</span></a>
                        </li>
                        <li class=""><a href="#messages" data-toggle="tab">Assigned employees <span
                                        class="badge badge-warning">{{ $clients->employeesCount }}</span></a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                              Delete this client <li class="fa fa-trash-o"></li>
                            </button>
                        </div>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4></h4>

                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Full name</th>
                                    <td>{{ $clients->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $clients->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email address</th>
                                    <td>{{ $clients->email }}</td>
                                </tr>
                                <tr>
                                    <th>Section</th>
                                    <td>{{ $clients->section }}</td>
                                </tr>
                                <tr>
                                    <th>Budget</th>
                                    <td>
                                        <button type="submit"
                                                class="btn btn-default">{{ $clients->formattedBudget }}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $clients->is_active ? 'Active' : 'Deactive' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <h4>List of companies</h4>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Tax number</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                </tr>
                                @foreach($clients->companies as $companies)
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td>{{ $companies->name }}</td>
                                        <td>{{ $companies->tax_number }}</td>
                                        <td>{{ $companies->phone }}</td>
                                        <td>
                                            {{ Form::open(array('url' => 'clients/delete/' . $companies->id, 'class' => 'pull-right')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete this companies', array('class' => 'btn btn-danger btn-sm')) }}
                                            {{ Form::close() }}
                                        </td>
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="messages">
                            <h4>List of employeees</h4>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                                <thead>
                                <tr>
                                    <th>Full name</th>
                                    <th>Phone</th>
                                    <th>Email address</th>
                                    <th>Job</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                </tr>
                                @foreach($clients->employees as $employees)
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td>{{ $employees->full_name }}</td>
                                        <td>{{ $employees->phone }}</td>
                                        <td>{{ $employees->email }}</td>
                                        <td>{{ $employees->job }}</td>
                                        <td>
                                            {{ Form::open(array('url' => 'employees/delete/' . $employees->id, 'class' => 'pull-right')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete this employee', array('class' => 'btn btn-danger btn-sm')) }}
                                            {{ Form::close() }}
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
                    <h4 class="modal-title" id="myModalLabel">You want delete this client?</h4>
                </div>
                <div class="modal-body">
                    Ation will delete permanently this client.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 15px;">Close</button>
                    {{ Form::open(array('url' => 'clients/delete/' . $clients->id, 'class' => 'pull-right')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete this client', array('class' => 'btn btn-small btn-danger')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection