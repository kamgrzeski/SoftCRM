@extends('layouts.base')

@section('caption', 'List of employees')

@section('title', 'List of employees')

@section('lyric', 'lorem ipsum')

@section('content')
    <div class="row">
        <div class="col-md-12">
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
            {!! Form::open(array('route' => 'employees/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder'=>'Write name of employees...')) !!}
            {!! Form::submit('Search',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('employees/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Add employees</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    List of employees
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Full name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email address</th>
                                <th class="text-center">Job</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Note</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $key => $value)
                                <tr class="odd gradeX">

                                    <td class="text-center">{{ $value->full_name }}</td>
                                    <td class="text-center">{{ $value->phone }}</td>
                                    <td class="text-center">{{ $value->email }}</td>
                                    <td class="text-center">{{ $value->job }}</td>
                                    <td class="text-center">{{ $value->client_id }}</td>
                                    <td class="text-center">{{ $value->note }}</td>
                                    <td class="text-center">
                                        @if($value->is_active == TRUE)
                                            <input type="checkbox" data-on="Active" checked data-toggle="toggle" onchange='window.location.assign("{{ URL::to('employees/disable/' . $value->id) }}")'/>
                                        @else
                                            <input type="checkbox" data-off="Deactivate" data-toggle="toggle" onchange='window.location.assign("{{ URL::to('employees/enable/' . $value->id) }}")'/>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-small btn-warning"
                                           href="{{ URL::to('employees/' . $value->id) }}">More information</a>
                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('employees/' . $value->id . '/edit') }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            {!! $employeesPaginate->render() !!}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection