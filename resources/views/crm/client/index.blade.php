@extends('layouts.base')

@section('caption', 'List of clients')

@section('title', 'List of clients')

@section('lyric', '')

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
            {!! Form::open(array('route' => 'client/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder'=>'Write name of client...')) !!}
            {!! Form::submit('Search',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('client/create') }}">
                <button type="button" class="btn btn-primary btn active">Add client</button>
            </a>
            <br><br>
            @if (isset($clients_search))
            <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List of search clients
                    </div>
                    <div class="panel-body">
                        <div class="table">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                                <thead>
                                <tr>
                                    <th class="text-center">Full name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Email address</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Section</th>
                                    <th class="text-center">Budget</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width:200px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients_search as $key => $value)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $value->full_name }}</td>
                                        <td class="text-center">{{ $value->phone }}</td>
                                        <td class="text-center">{{ $value->email }}</td>
                                        <td class="text-center">{{ $value->section }}</td>
                                        <td class="text-center">{{ $value->budget }}</td>
                                        <td class="text-center">{{ $value->is_active }}</td>
                                        <td class="text-center">
                                            @if($value->is_active == TRUE)
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           onchange='window.location.assign("{{ URL::to('client/set-active/' . $value->id . '/0') }}")' checked>
                                                    <span class="slider"></span>
                                                </label>
                                            @else
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           onchange='window.location.assign("{{ URL::to('client/set-active/' . $value->id . '/1') }}")'>
                                                    <span class="slider"></span>
                                                </label>
                                            @endif
                                        </td>

                                        <td class="text-right">
                                            <a class="btn btn-small btn-success small-btn"
                                               href="{{ URL::to('client/' . $value->id) }}">More information</a>

                                            <a class="btn btn-small btn-info"
                                               href="{{ URL::to('client/' . $value->id . '/edit') }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--End Advanced Tables -->
            @elseif (isset($client))
            <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users" aria-hidden="true"></i> List of clients
                    </div>
                    <div class="panel-body">
                        <div class="table">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                                <thead>
                                <tr>
                                    <th class="text-center">Full name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Email address</th>
                                    <th class="text-center">Section</th>
                                    <th class="text-center">Budget</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width:200px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($client as $key => $value)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $value->full_name }}</td>
                                        <td class="text-center">{{ $value->phone }}</td>
                                        <td class="text-center">{{ $value->email }}</td>
                                        <td class="text-center">{{ $value->section }}</td>
                                        <td class="text-center">
                                            <button type="submit"
                                                    class="btn btn-default">{{ $value->budget }}</button>
                                        </td>
                                        <td class="text-center">
                                            @if($value->is_active == TRUE)
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           onchange='window.location.assign("{{ URL::to('client/set-active/' . $value->id . '/0') }}")' checked>
                                                    <span class="slider"></span>
                                                </label>
                                            @else
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           onchange='window.location.assign("{{ URL::to('client/set-active/' . $value->id . '/1') }}")'>
                                                    <span class="slider"></span>
                                                </label>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <a class="btn btn-small btn-primary"
                                                   href="{{ URL::to('client/' . $value->id) }}">More information</a>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{ URL::to('client/' . $value->id . '/edit') }}">Edit</a></li>
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
                        {!! $clientPaginate->render() !!}
                    </div>
                </div>
                <!--End Advanced Tables -->
            @else
                I don't have any records!
            @endif
        </div>
    </div>
@endsection