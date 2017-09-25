@extends('layouts.base')

@section('caption', 'Information about employee: ' . $employees->full_name)

@section('title', 'Information about employee: ' . $employees->full_name)


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
                        <div class="text-right">
                            {{ Form::open(array('url' => 'employees/' . $employees->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete this employee', array('class' => 'btn btn-small btn-danger')) }}
                            {{ Form::close() }}
                        </div>

                    </ul>
                    <div class="tab-pane fade active in" id="home">
                        <h4></h4>

                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Full name</th>
                                <td>{{ $employees->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $employees->phone }}</td>
                            </tr>
                            <tr>
                                <th>Email address</th>
                                <td>{{ $employees->email }}</td>
                            </tr>
                            <tr>
                                <th>Job</th>
                                <td>{{ $employees->job }}</td>
                            </tr>
                            <tr>
                                <th>Note</th>
                                <td>{{ $employees->note }}</td>
                            </tr>
                            <tr>
                                <th>Assigned client</th>
                                <td>
                                    <a href="{{ URL::to('client/' . $employees->client->id) }}">{{ $employees->client->full_name }}</a>
                                </td>

                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $employees->is_active ? 'Active' : 'Deactive' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection