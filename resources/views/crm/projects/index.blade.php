@extends('layouts.base')

@section('caption', 'List of projects')

@section('title', 'List of projects')

@section('content')
    <div class="row">`
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
            {!! Form::open(array('route' => 'projects/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder' => \App\Language::getMessage('messages.InputText'))) !!}
            {!! Form::submit('Search',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('projects/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Add projects</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of projects
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">assigned client</th>
                                <th class="text-center">assigned companie</th>
                                <th class="text-center">assigned deal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->client_id }}</td>
                                    <td class="text-center">{{ $value->companies_id }}</td>
                                    <td class="text-center">{{ $value->deals_id }}</td>
                                    <td class="text-center">
                                        @if($value->is_active == TRUE)
                                            <input type="checkbox" data-on="Active" checked data-toggle="toggle"
                                                   onchange='window.location.assign("{{ URL::to('projects/disable/' . $value->id) }}")'/>
                                        @else
                                            <input type="checkbox" data-off="Deactivate" data-toggle="toggle"
                                                   onchange='window.location.assign("{{ URL::to('projects/enable/' . $value->id) }}")'/>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-small btn-success"
                                           href="{{ URL::to('projects/' . $value->id) }}">More information</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('projects/' . $value->id . '/edit') }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            {!! $projectsPaginate->render() !!}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection