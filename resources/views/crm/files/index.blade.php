@extends('layouts.base')

@section('caption', 'List of files')

@section('title', 'List of files')

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
            {!! Form::open(array('route' => 'files/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder'=>'Write name of files...')) !!}
            {!! Form::submit('Search',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('files/create') }}">
                <button type="button" class="btn btn-primary btn active">Add files</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of files
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Deal between company</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center"><a
                                                href="{{ URL::to('companies/' . $value->companies->id) }}">{{ $value->companies->name }}</a>
                                    </td>
                                    <td class="text-center">
                                        @if($value->is_active == TRUE)
                                            <label class="switch">
                                                <input type="checkbox"
                                                       onchange='window.location.assign("{{ URL::to('files/set-active/' . $value->id . '/0') }}")' checked>
                                                <span class="slider"></span>
                                            </label>
                                        @else
                                            <label class="switch">
                                                <input type="checkbox"
                                                       onchange='window.location.assign("{{ URL::to('files/set-active/' . $value->id . '/1') }}")'>
                                                <span class="slider"></span>
                                            </label>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary"
                                               href="{{ URL::to('files/' . $value->id) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ URL::to('files/' . $value->id . '/edit') }}">Edit</a></li>
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
                    {!! $filesPaginate->render() !!}

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection