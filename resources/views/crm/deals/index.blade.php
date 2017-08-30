@extends('layouts.base')

@section('caption', 'List of deals')

@section('title', 'List of deals')

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
            <a href="{{ URL::to('deals/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Add deals</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    List of deals
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Deal between company</th>
                                <th class="text-center">Start date</th>
                                <th class="text-center">End date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deals as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center"><a href="{{ URL::to('companies/' . $value->companies->id) }}">{{ $value->companies->name }}</a></td>
                                    <td class="text-center">{{ $value->start_time }}</td>
                                    <td class="text-center">{{ $value->end_time }}</td>
                                    <td class="text-center">
                                        @if($value->is_active == TRUE)
                                            <input type="checkbox" data-on="Active" checked data-toggle="toggle" onchange='window.location.assign("{{ URL::to('deals/disable/' . $value->id) }}")'/>
                                        @else
                                            <input type="checkbox" data-off="Deactivate" data-toggle="toggle" onchange='window.location.assign("{{ URL::to('deals/enable/' . $value->id) }}")'/>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-small btn-success"
                                           href="{{ URL::to('deals/' . $value->id) }}">More information</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('deals/' . $value->id . '/edit') }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            {!! $dealsPaginate->render() !!}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection