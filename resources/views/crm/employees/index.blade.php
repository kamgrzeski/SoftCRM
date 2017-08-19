@extends('layouts.base')

@section('caption', 'Lista pracowników')

@section('title', 'Lista pracowników')

@section('lyric', 'lorem ipsum')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- will be used to show any messages -->
            @if(session()->has('message_success'))
                <div class="alert alert-success">
                    <strong>Bardzo dobrze!</strong> {{ session()->get('message_success') }}
                </div>
            @elseif(session()->has('message_danger'))
                <div class="alert alert-danger">
                    <strong>Uwaga!</strong> {{ session()->get('message_danger') }}
                </div>
            @endif
            <a href="{{ URL::to('employees/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Dodaj pracownika</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista pracowników
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Imie i naziwsko</th>
                                <th class="text-center">Telefon</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Stanowisko</th>
                                <th class="text-center">Notatnik</th>
                                <th class="text-center">Firma</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Akcja</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $key => $value)
                                <tr class="odd gradeX">

                                    <td class="text-center">{{ $value->full_name }}</td>
                                    <td class="text-center">{{ $value->phone }}</td>
                                    <td class="text-center">{{ $value->email }}</td>
                                    <td class="text-center">{{ $value->job }}</td>
                                    <td class="text-center">{{ $value->note }}</td>
                                    <td class="text-center">
                                        <a href="{{ URL::to('employees/' . $value->id) }}">{{ $value->full_name }}</a>
                                    </td>
                                    <td class="text-center">{{ $value->is_active ? 'Yes' : 'No' }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('employees/' . $value->id . '/edit') }}">Edytuj</a>
                                        @if($value->is_active == TRUE)
                                            <a class="btn btn-small btn-warning"
                                               href="{{ URL::to('employees/disable/' . $value->id) }}">Deaktywuj</a>
                                        @else
                                            <a class="btn btn-small btn-warning"
                                               href="{{ URL::to('employees/enable/' . $value->id) }}">Aktywuj</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            {!! $employeesPaginate->render() !!}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection