@extends('layouts.base')

@section('caption', 'Lista spotkań')

@section('title', 'Lista spotkań')

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
            <a href="{{ URL::to('contacts/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Dodaj spotkanie</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista spotkań
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Klient</th>
                                <th class="text-center">Pracownik</th>
                                <th class="text-center">Data</th>
                                <th class="text-center">Akcja</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->client_id }}</td>
                                    <td class="text-center">{{ $value->employee_id }}</td>
                                    <td class="text-center">{{ $value->date }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-small btn-success"
                                           href="{{ URL::to('companies/' . $value->id) }}">Więcej informacji</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('companies/' . $value->id . '/edit') }}">Edytuj</a>
                                        @if($value->is_active == TRUE)
                                            <a class="btn btn-small btn-warning"
                                               href="{{ URL::to('companies/disable/' . $value->id) }}">Deaktywuj</a>
                                        @else
                                            <a class="btn btn-small btn-warning"
                                               href="{{ URL::to('companies/enable/' . $value->id) }}">Aktywuj</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            {!! $contactsPaginate->render() !!}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection