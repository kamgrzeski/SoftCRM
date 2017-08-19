@extends('layouts.base')

@section('caption', 'Lista umów')

@section('title', 'Lista umów')

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
            <a href="{{ URL::to('deals/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Dodaj umowę</button>
            </a>
            <br><br>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Lista umów
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Nazwa</th>
                                <th class="text-center">Umowa między firmą</th>
                                <th class="text-center">Rozpoczęcie umowy</th>
                                <th class="text-center">Zakończenie umowy</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Akcja</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deals as $key => $value)
                                <tr class="odd gradeX">

                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center"><a href="{{ URL::to('companies/' . $value->companies->id) }}">{{ $value->companies->name }}</a></td>
                                    <td class="text-center">{{ $value->start_time }}</td>
                                    <td class="text-center">{{ $value->end_time }}</td>
                                    <td class="text-center">{{ $value->is_active ? 'Yes' : 'No' }}</td>

                                    <td class="text-right">
                                        <a class="btn btn-small btn-success"
                                           href="{{ URL::to('deals/' . $value->id) }}">Więcej informacji</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('deals/' . $value->id . '/edit') }}">Edytuj</a>
                                        @if($value->is_active == TRUE)
                                            <a class="btn btn-small btn-warning"
                                               href="{{ URL::to('deals/disable/' . $value->id) }}">Deaktywuj</a>
                                        @else
                                            <a class="btn btn-small btn-warning"
                                               href="{{ URL::to('deals/enable/' . $value->id) }}">Aktywuj</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            {!! $dealsPaginate->render() !!}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection