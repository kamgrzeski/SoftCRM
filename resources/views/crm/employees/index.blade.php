@extends('layouts.base')

@section('caption', 'List of employees')

@section('title', 'List of employees')

@section('lyric', '')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ route('employees.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add employees</button>
            </a>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-code-fork" aria-hidden="true"></i> List of employees
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                <th class="text-center">Full name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email address</th>
                                <th class="text-center">Job</th>
                                <th class="text-center">Assigned client</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $key => $employee)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $employee->full_name }}</td>
                                    <td class="text-center">{{ $employee->phone }}</td>
                                    <td class="text-center">{{ $employee->email }}</td>
                                    <td class="text-center">{{ $employee->job }}</td>
                                    <td class="text-center"><a
                                                href="{{ route('clients.view', $employee->client->id) }}">{{ $employee->client->full_name }}</a>
                                    </td>
                                    <td class="text-center">
                                                <form method="POST" action="{{ route('employees.set.active', $employee) }}">
                                                    @csrf
                                                    <label class="switch">
                                                        <input type="checkbox" onchange="this.form.submit()" @if($employee->is_active) checked @endif>
                                                        <span class="slider"></span>
                                                    </label>
                                                </form>
                                    </td>
                                    <td class="text-right" style="text-align: center">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{ route('employees.view', $employee) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('employees.update.form', $employee) }}">Edit</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Some option</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $employees->render() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
