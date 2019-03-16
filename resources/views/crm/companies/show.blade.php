@extends('layouts.base')

@section('caption', 'Information about companies')

@section('title', 'Information about companies')

@section('lyric', '')

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
                <div class="panel-heading">
                    More information about {{ $companies->name }}
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Invoices <span
                                        class="badge badge-warning">0</span></a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                Delete this companise <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4></h4>

                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $companies->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tax number</th>
                                    <td>{{ $companies->tax_number }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $companies->phone }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $companies->city }}</td>
                                </tr>
                                <tr>
                                    <th>Billing Address</th>
                                    <td>{{ $companies->billing_address }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $companies->country }}</td>
                                </tr>
                                <tr>
                                    <th>Postal code</th>
                                    <td>{{ $companies->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Employee size</th>
                                    <td>{{ $companies->employees_size }}</td>
                                </tr>
                                <tr>
                                    <th>Assigned client</th>
                                    <td>
                                        <a href="{{ URL::to('client/' . $companies->client->id) }}">{{ $companies->client->full_name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $companies->fax }}</td>
                                </tr>
                                <tr height="100px">
                                    <th>Description</th>
                                    <td>{{ $companies->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $companies->is_active ? 'Yes' : 'No' }}</td>
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">You want delete this companies?</h4>
                </div>
                <div class="modal-body">
                    Ation will delete permanently this companies.
                </div>
                <div class="modal-footer">
                    {{ Form::open(array('url' => 'companies/delete/' . $companies->id, 'class' => 'pull-right')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete this companie', array('class' => 'btn btn-small btn-danger')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection