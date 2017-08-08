@extends('layouts.base')

@section('caption', 'Show company')

@section('title', 'show company')

@section('lyric', 'show company')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    Więcej informacji na temat {{ $client->name }}
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Podstawowe informacje</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Faktury <span
                                        class="badge badge-warning">0</span></a>
                        </li>
                        <li class=""><a href="#messages" data-toggle="tab">Pracownicy <span
                                        class="badge badge-warning">0</span></a>
                        </li>
                        <div class="text-right">
                            {{ Form::open(array('url' => 'client/' . $client->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Usuń', array('class' => 'btn btn-small btn-danger')) }}
                            {{ Form::close() }}
                            @if($client->is_active == TRUE)
                                <a class="btn btn-small btn-warning"
                                   href="{{ URL::to('client/disable/' . $client->id) }}">Deaktywuj</a>
                            @else
                                <a class="btn btn-small btn-warning"
                                   href="{{ URL::to('client/enable/' . $client->id) }}">Aktywuj</a>
                            @endif
                        </div>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4></h4>

                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Imie i nazwisko</th>
                                    <td>{{ $client->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Telefon</th>
                                    <td>{{ $client->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Adres email</th>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $client->is_active }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <h4>Profile Tab</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.</p>
                        </div>
                        <div class="tab-pane fade" id="messages">
                            <h4>Messages Tab</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection