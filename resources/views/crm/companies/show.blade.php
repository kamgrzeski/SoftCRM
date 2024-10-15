@extends('layouts.base')

@section('title', 'Information about companies')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            @include('layouts.template.messages')
            <div class="panel panel-default">
                <div class="panel-heading">
                    More information about {{ $company->name }}
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteCompanyModal">
                                Delete this company <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $company->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tax number</th>
                                    <td>{{ $company->tax_number }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $company->phone }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $company->city }}</td>
                                </tr>
                                <tr>
                                    <th>Billing Address</th>
                                    <td>{{ $company->billing_address }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $company->country }}</td>
                                </tr>
                                <tr>
                                    <th>Postal code</th>
                                    <td>{{ $company->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Employee size</th>
                                    <td>{{ $company->employees_size }}</td>
                                </tr>
                                <tr>
                                    <th>Assigned client</th>
                                    <td>
                                        <a href="{{ route('clients.view', $company->client) }}">{{ $company->client->full_name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $company->fax }}</td>
                                </tr>
                                <tr height="100px">
                                    <th>Description</th>
                                    <td>{{ $company->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $company->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <h4>Lorem ipsum</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('crm.companies.modals.delete_company_modal')
@endsection
