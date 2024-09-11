@extends('layouts.base')

@section('caption', 'Information about client: ' . $clientDetails->full_name)

@section('title', 'Information about client: ' . $clientDetails->full_name)

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            @include('layouts.template.messages')
            <br/>
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <li class="">
                            <a href="#profile" data-toggle="tab">Assigned companies <span class="badge badge-warning">{{ count($clientDetails->companies) }}</span></a>
                        </li>
                        <li class="">
                            <a href="#messages" data-toggle="tab">Assigned employees <span class="badge badge-warning">{{ count($clientDetails->employees) }}</span></a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteClientModal">
                                Delete this client
                                <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Full name</th>
                                    <td>{{ $clientDetails->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $clientDetails->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email address</th>
                                    <td>{{ $clientDetails->email }}</td>
                                </tr>
                                <tr>
                                    <th>Section</th>
                                    <td>{{ $clientDetails->section }}</td>
                                </tr>
                                <tr>
                                    <th>Budget</th>
                                    <td>
                                        <button type="submit" class="btn btn-default">{{ $clientDetails->formattedBudget }}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $clientDetails->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <h4>List of companies</h4>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example"
                                   data-sortable>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Tax number</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($clientDetails->companies as $company)
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->tax_number }}</td>
                                        <td>{{ $company->phone }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade">
                            <h4>List of employee's</h4>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example-sort-employees" data-sortable>
                                <thead>
                                <tr>
                                    <th>Full name</th>
                                    <th>Phone</th>
                                    <th>Email address</th>
                                    <th>Job</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($clientDetails->employees as $employees)
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td>{{ $employees->full_name }}</td>
                                        <td>{{ $employees->phone }}</td>
                                        <td>{{ $employees->email }}</td>
                                        <td>{{ $employees->job }}</td>
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

    @include('crm.clients.modals.delete_client_modal')
@endsection
