@extends('layouts.base')

@section('caption', 'Information about client: ' . $client->full_name)

@section('title', 'Information about client: ' . $client->full_name)

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
                            <a href="#companies" data-toggle="tab">Assigned companies <span class="badge badge-warning">{{ count($client->companies) }}</span></a>
                        </li>
                        <li class="">
                            <a href="#employees" data-toggle="tab">Assigned employees <span class="badge badge-warning">{{ count($client->employees) }}</span></a>
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
                                    <td>{{ $client->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $client->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email address</th>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                <tr>
                                    <th>Section</th>
                                    <td>{{ $client->section }}</td>
                                </tr>
                                <tr>
                                    <th>Budget</th>
                                    <td>
                                        <button type="submit" class="btn btn-default">{{ $client->formattedBudget }}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $client->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="companies">
                            <h4>List of companies</h4>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example"
                                   data-sortable>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Tax number</th>
                                </tr>
                                </thead>
                                @foreach($client->companies as $company)
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
                        <div class="tab-pane fade" id="employees">
                            <h4>List of employee's</h4>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example-sort-employees" data-sortable>
                                <thead>
                                <tr>
                                    <th>Full name</th>
                                    <th>Phone</th>
                                    <th>Email address</th>
                                    <th>Job</th>
                                </tr>
                                </thead>
                                @foreach($client->employees as $employees)
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
