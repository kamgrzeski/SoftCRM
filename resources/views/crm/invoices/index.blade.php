@extends('layouts.base')

@section('caption', 'List of invoices')

@section('title', 'List of invoices')

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
            {!! Form::open(array('route' => 'invoices/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder'=>'Write name of invoices...')) !!}
            {!! Form::submit('Search',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('invoices/create') }}">
                <button type="button" class="btn btn-primary btn active">Add invoices</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of invoices
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:180px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">
                                            @if($value->is_active == TRUE)
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           onchange='window.location.assign("{{ URL::to('invoices/set-active/' . $value->id . '/0') }}")' checked>
                                                    <span class="slider"></span>
                                                </label>
                                            @else
                                                <label class="switch">
                                                    <input type="checkbox"
                                                           onchange='window.location.assign("{{ URL::to('invoices/set-active/' . $value->id . '/1') }}")'>
                                                    <span class="slider"></span>
                                                </label>
                                            @endif
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-small btn-warning small-btn"
                                           href="{{ URL::to('invoices/download/' . $value->id) }}">Download invoice</a>
                                        <a class="btn btn-small btn-success small-btn"
                                           href="{{ URL::to('invoices/' . $value->id) }}">More information</a>
                                        <a class="btn btn-small btn-info small-btn"
                                           href="{{ URL::to('invoices/' . $value->id . '/edit') }}">Edit</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $invoicesPaginate->render() !!}

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection