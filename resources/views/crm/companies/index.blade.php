@extends('layouts.base')

@section('caption', 'Lista firm')

@section('title', 'Lista firm')

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
            <a href="{{ URL::to('companies/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Dodaj firmę</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista firm
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Nazwa</th>
                                <th class="text-center">Telefon</th>
                                <th class="text-center">Miasto</th>
                                <th class="text-center">Państwo</th>
                                <th class="text-center">Liczba pracowników</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Klient</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Akcja</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $key => $value)
                                <tr class="odd gradeX">

                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->phone }}</td>
                                    <td class="text-center">{{ $value->city }}</td>
                                    <td class="text-center">{{ $value->country }}</td>
                                    <td class="text-center">{{ $value->employees }}</td>
                                    <td class="text-center">{{ $value->tax_number }}</td>
                                    <td class="text-center">
                                        <a href="{{ URL::to('client/' . $value->client->id) }}">{{ $value->client->full_name }}</a>
                                    </td>
                                    <td class="text-center">{{ $value->is_active ? 'Yes' : 'No' }}</td>

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
                            {!! $companiesPaginate->render() !!}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection