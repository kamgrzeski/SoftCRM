@extends('layouts.base')

@section('caption', 'Lista klientów')

@section('title', 'Lista klientów')

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
            {!! Form::open(array('route' => 'client/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder'=>'Wpisz nazwę klienta...')) !!}
            {!! Form::submit('Wyszukaj',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('client/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Dodaj klienta</button>
            </a>
            <br><br>
            @if (isset($clients_search))
            <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Lista wyszukanych przez ciebie klientów
                    </div>
                    <div class="panel-body">
                        <div class="table">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="text-center">Imię i nazwisko</th>
                                    <th class="text-center">Telefon</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Akcja</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clients_search as $key => $value)
                                    <tr class="odd gradeX">

                                        <td class="text-center">{{ $value->full_name }}</td>
                                        <td class="text-center">{{ $value->phone }}</td>
                                        <td class="text-center">{{ $value->email }}</td>
                                        <td class="text-center">{{ $value->is_active ? 'Yes' : 'No' }}</td>
                                        <td class="text-right">
                                            <a class="btn btn-small btn-success"
                                               href="{{ URL::to('client/' . $value->id) }}">Więcej informacji</a>

                                            <a class="btn btn-small btn-info"
                                               href="{{ URL::to('client/' . $value->id . '/edit') }}">Edytuj</a>
                                            @if($value->is_active == TRUE)
                                                <a class="btn btn-small btn-warning"
                                                   href="{{ URL::to('client/disable/' . $value->id) }}">Deaktywuj</a>
                                            @else
                                                <a class="btn btn-small btn-warning"
                                                   href="{{ URL::to('client/enable/' . $value->id) }}">Aktywuj</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                {!! $clientPaginate->render() !!}
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->
            @elseif (isset($client))
            <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Lista klientów
                    </div>
                    <div class="panel-body">
                        <div class="table">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="text-center">Imię i nazwisko</th>
                                    <th class="text-center">Telefon</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Akcja</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($client as $key => $value)
                                    <tr class="odd gradeX">

                                        <td class="text-center">{{ $value->full_name }}</td>
                                        <td class="text-center">{{ $value->phone }}</td>
                                        <td class="text-center">{{ $value->email }}</td>
                                        <td class="text-center">
                                            @if($value->is_active == TRUE)
                                                <input type="checkbox" data-on="Aktywny" checked data-toggle="toggle" onchange='window.location.assign("{{ URL::to('client/disable/' . $value->id) }}")'/>
                                            @else
                                                <input type="checkbox" data-off="Nieaktywny" data-toggle="toggle" onchange='window.location.assign("{{ URL::to('client/enable/' . $value->id) }}")'/>
                                            @endif
                                        </td>

                                        <td class="text-right">
                                            <a class="btn btn-small btn-success"
                                               href="{{ URL::to('client/' . $value->id) }}">Więcej informacji</a>

                                            <a class="btn btn-small btn-info"
                                               href="{{ URL::to('client/' . $value->id . '/edit') }}">Edytuj</a>
                                        </td>
                                    </tr>
                                @endforeach
                                {!! $clientPaginate->render() !!}
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->
            @else
                I don't have any records!
            @endif
        </div>
    </div>
@endsection