@extends('layouts.base')

@section('caption', 'Information about files')

@section('title', 'Information about files')

@section('lyric', 'Information about files')

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
                    More information about {{ $files->name }}
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">The basic information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Company <span
                                        class="badge badge-warning">{{ count($files->companies) }}</span></a>
                        </li>
                        <div class="text-right">
                            {{ Form::open(array('url' => 'files/' . $files->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete this files', array('class' => 'btn btn-small btn-danger')) }}
                            {{ Form::close() }}
                        </div>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4></h4>

                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $files->name }}</td>
                                </tr>
                                <tr>
                                    <th>Deal between company</th>
                                    <td>
                                        <a href="{{ URL::to('companies/' . $files->companies->id) }}">{{ $files->companies->name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Start date</th>
                                    <td>{{ $files->start_time }}</td>
                                </tr>
                                <tr>
                                    <th>End date</th>
                                    <td>{{ $files->end_time }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $files->is_active ? 'Yes' : 'No' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <p>
                            <table class="table table-striped table-bordered">
                                <h4>Full information about <strong>{{ $files->companies->name }}</strong></h4><br>
                                <tbody class="text-right">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $files->companies->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tax number</th>
                                    <td>{{ $files->companies->tax_number }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $files->companies->phone }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $files->companies->city }}</td>
                                </tr>
                                <tr>
                                    <th>Billing address</th>
                                    <td>{{ $files->companies->billing_address }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $files->companies->country }}</td>
                                </tr>
                                <tr>
                                    <th>Postal code</th>
                                    <td>{{ $files->companies->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Employees size</th>
                                    <td>{{ $files->companies->employees_size }}</td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $files->companies->fax }}</td>
                                </tr>
                                <tr height="100px">
                                    <th>Description</th>
                                    <td>{{ $files->companies->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $files->companies->is_active ? 'Yes' : 'No' }}</td>
                                </tr>
                                </tbody>
                            </table>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="messages">
                            <h4>Terms of agreement</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection