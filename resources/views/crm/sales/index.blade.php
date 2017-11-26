@extends('layouts.base')

@section('caption', 'List of sales')

@section('title', 'List of sales')

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
            {!! Form::open(array('route' => 'sales/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder'=>'Write name of sales...')) !!}
            {!! Form::submit('Search',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('sales/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Add sales</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of sales
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">
                                        @if($value->is_active == TRUE)
                                            <input type="checkbox" data-on="Active" checked data-toggle="toggle"
                                                   onchange='window.location.assign("{{ URL::to('sales/set-active/' . $value->id . '/0') }}")'/>
                                        @else
                                            <input type="checkbox" data-off="Deactivate" data-toggle="toggle"
                                                   onchange='window.location.assign("{{ URL::to('sales/set-active/' . $value->id . '/1') }}")'/>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-small btn-success"
                                           href="{{ URL::to('sales/' . $value->id) }}">More information</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('sales/' . $value->id . '/edit') }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $salesPaginate->render() !!}
                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection