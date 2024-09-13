@extends('layouts.base')

@section('caption', 'Information about employee: ' . $finance->full_name)

@section('title', 'Information about employee: ' . $finance->full_name)

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            @include('layouts.template.messages')
            <br/>
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a></li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteFinanceModal">
                                Delete this finance <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>
                    <div class="tab-pane fade active in" id="home">
                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Full name</th>
                                <td>{{ $finance->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $finance->description }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $finance->category }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $finance->type }}</td>
                            </tr>
                            <tr>
                                <th>Gross</th>
                                <td>{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($finance->gross) }}</td>
                            </tr>
                            <tr>
                                <th>Net</th>
                                <td>{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($finance->net) }}</td>
                            </tr>
                            <tr>
                                <th>Vat</th>
                                <td>{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($finance->vat) }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ $finance->date }}</td>
                            </tr>
                            <tr>
                                <th>Assigned companies</th>
                                <td>
                                    <a href="{{ url()->to('companies/view/' . $finance->companies->id) }}">{{ $finance->companies->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $finance->is_active ? 'Active' : 'Deactivate' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('crm.finances.modals.delete_finance_modal')
@endsection
