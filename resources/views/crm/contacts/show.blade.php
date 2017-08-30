@extends('layouts.base')

@section('caption', 'Information about contact')

@section('title', 'Information about contact')


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
                            {{ Form::open(array('url' => 'contacts/' . $contacts->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete this contact', array('class' => 'btn btn-small btn-danger')) }}
                            {{ Form::close() }}
                        </div>

                    </ul>
                    <div class="tab-pane fade active in" id="home">
                        <h4></h4>

                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Assigned client</th>
                                <td>{{ $contacts->client_id }}</td>
                            </tr>
                            <tr>
                                <th>Assigned employee</th>
                                <td>{{ $contacts->employee_id  }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ $contacts->date }}</td>
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