@extends('layouts.base')

@section('title', 'List of finances')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ route('finances.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add finances</button>
            </a>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-code-fork" aria-hidden="true"></i> List of finances
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
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
                            @foreach($finances as $key => $finance)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $finance->name }}</td>
                                    <td class="text-center">{{ $finance->category }}</td>
                                    <td class="text-center">{{ $finance->type }}</td>
                                    <td>
                                        <button type="submit" class="btn btn-default" style="background-color: rgba(130,113,243,0.22)">{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($finance->gross) }}</button>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-default" style="background-color: rgba(113,243,110,0.45)">{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($finance->net) }}</button>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-default" style="background-color: rgba(217,243,30,0.45)">{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($finance->vat) }}</button>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('companies.view', $finance->company->id) }}">{{ $finance->company->name }}</a>
                                    </td>
                                    <td class="text-center">{{ $finance->date }}</td>
                                    <td class="text-center">
                                            <form method="POST" action="{{ route('finances.set.active', $finance) }}">
                                                @csrf
                                                <label class="switch">
                                                    <input type="checkbox" onchange="this.form.submit()" @if($finance->is_active) checked @endif>
                                                    <span class="slider"></span>
                                                </label>
                                            </form>
                                    </td>
                                    <td class="text-right" style="text-align: center">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{ route('finances.view', $finance) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('finances.update.form', $finance) }}">Edit</a></li>
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
                    {!! $finances->render() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
