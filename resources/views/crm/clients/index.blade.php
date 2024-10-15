@extends('layouts.base')

@section('title', 'List of clients')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')

            <a href="{{ route('clients.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add client</button>
            </a>
            <br><br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users" aria-hidden="true"></i> List of clients
                    </div>
                    <div class="panel-body">
                        <div class="table">
                            <table class="table table-striped table-bordered table-hover" id="dataTables">
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
                                @foreach($clients as $key => $client)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $client->full_name }}</td>
                                        <td class="text-center">{{ $client->phone }}</td>
                                        <td class="text-center">{{ $client->email }}</td>
                                        <td class="text-center">{{ $client->section }}</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-default">{{ \Cknow\Money\Money::{\App\Models\SettingsModel::getSettingValue('currency')}($client->budget) }}</button>
                                        </td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('clients.set.active', $client) }}">
                                                @csrf
                                                <label class="switch">
                                                    <input type="checkbox" onchange="this.form.submit()" @if($client->is_active) checked @endif>
                                                        <span class="slider"></span>
                                                </label>
                                            </form>
                                        </td>
                                        <td class="text-right" style="text-align: center">
                                            <div class="btn-group">
                                                <a class="btn btn-small btn-primary" href="{{ route('clients.view', $client) }}">More information</a>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{ route('clients.update.form', $client) }}">Edit</a></li>
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
                        {!! $clients->render() !!}
                    </div>
                </div>
        </div>
    </div>
@endsection
