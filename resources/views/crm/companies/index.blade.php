@extends('layouts.base')

@section('caption', 'List of companies')

@section('title', 'List of companies')

@section('lyric', '')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ route('companies.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add companies</button>
            </a>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-calendar-o" aria-hidden="true"></i> List of companies
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">City</th>
                                <th class="text-center">Country</th>
                                <th class="text-center">Employes count</th>
                                <th class="text-center">Tax number</th>
                                <th class="text-center">Client</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $key => $company)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $company->name }}</td>
                                    <td class="text-center">{{ $company->phone }}</td>
                                    <td class="text-center">{{ $company->city }}</td>
                                    <td class="text-center">{{ $company->country }}</td>
                                    <td class="text-center">{{ $company->employees_size }}</td>
                                    <td class="text-center">{{ $company->tax_number }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('clients.view', $company->client) }}">{{ $company->client->full_name }}</a>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('companies.set.active', $company) }}">
                                            @csrf
                                            <label class="switch">
                                                <input type="checkbox" onchange="this.form.submit()" @if($company->is_active) checked @endif>
                                                <span class="slider"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td class="text-right" style="text-align: center">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{ route('companies.view', $company) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('companies.update.form', $company) }}">Edit</a></li>
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
                    {!! $companies->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
