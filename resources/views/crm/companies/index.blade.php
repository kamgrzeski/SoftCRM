@extends('layouts.base')

@section('caption', 'Companies')

@section('title', 'Companies')

@section('lyric', 'some text about Companies.')

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
                    {{ session()->get('message_danger') }}
                </div>
            @endif
                <a href="{{ URL::to('companies/create') }}"><button type="button" class="btn btn-primary btn-lg active">Add Companies</button></a>
                <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Companies list
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Tax number</th>
                                <th class="text-center">Tags</th>
                                <th class="text-center">City</th>
                                <th class="text-center">Active</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $key => $value)
                                <tr class="odd gradeX">

                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->tax_number }}</td>
                                    <td class="text-center"><a class="btn btn-default btn-sm">{{ $value->tags }}</a></td>
                                    <td class="text-center">{{ $value->city }}</td>
                                    <td class="text-center">{{ $value->is_active ? 'Yes' : 'No' }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-small btn-success" href="{{ URL::to('companies/' . $value->id) }}">More informations</a>

                                        <a class="btn btn-small btn-info" href="{{ URL::to('companies/' . $value->id . '/edit') }}">Edit</a>
                                        @if($value->is_active == TRUE)
                                            <a class="btn btn-small btn-warning" href="{{ URL::to('companies/disable/' . $value->id) }}">Disable</a>
                                        @else
                                            <a class="btn btn-small btn-warning" href="{{ URL::to('companies/enable/' . $value->id) }}">Enable</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection