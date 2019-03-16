@extends('layouts.base')

@section('caption', 'List of finances')

@section('title', 'List of finances')

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
            <a href="{{ URL::to('finances/create') }}">
                <button type="button" class="btn btn-primary btn active">Add finances</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-code-fork" aria-hidden="true"></i> List of finances
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Gross</th>
                                <th class="text-center">Net</th>
                                <th class="text-center">Vat</th>
                                <th class="text-center">Assigned companies</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($finances as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->category }}</td>
                                    <td class="text-center">{{ $value->type }}</td>
                                    <td>
                                        <button type="submit"
                                                class="btn btn-default" style="background-color: rgba(130,113,243,0.22)">{{ \ClickNow\Money\Money::{config('crm_settings.currency')}($value->gross) }}</button>
                                    </td>
                                    <td>
                                        <button type="submit"
                                                class="btn btn-default" style="background-color: rgba(113,243,110,0.45)">{{ \ClickNow\Money\Money::{config('crm_settings.currency')}($value->net) }}</button>
                                    </td>
                                    <td>
                                        <button type="submit"
                                                class="btn btn-default" style="background-color: rgba(217,243,30,0.45)">{{ \ClickNow\Money\Money::{config('crm_settings.currency')}($value->vat) }}</button>
                                    </td>
                                    <td class="text-center"><a
                                                href="{{ URL::to('companies/' . $value->companies->id) }}">{{ $value->companies->name }}</a>
                                    </td>
                                    <td class="text-center">{{ $value->date }}</td>
                                    <td class="text-center">
                                        @if($value->is_active == TRUE)
                                            <label class="switch">
                                                <input type="checkbox"
                                                       onchange='window.location.assign("{{ URL::to('finances/set-active/' . $value->id . '/0') }}")' checked>
                                                <span class="slider"></span>
                                            </label>
                                        @else
                                            <label class="switch">
                                                <input type="checkbox"
                                                       onchange='window.location.assign("{{ URL::to('finances/set-active/' . $value->id . '/1') }}")'>
                                                <span class="slider"></span>
                                            </label>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary"
                                               href="{{ URL::to('finances/' . $value->id) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ URL::to('finances/' . $value->id . '/edit') }}">Edit</a></li>
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
                    {!! $financesPaginate->render() !!}

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection