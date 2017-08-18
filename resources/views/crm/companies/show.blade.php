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
                    Więcej informacji na temat {{ $companies->name }}
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Podstawowe informacje</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Klienci <span
                                        class="badge badge-warning">0</span></a>
                        </li>
                        <li class=""><a href="#messages" data-toggle="tab">Pracownicy <span
                                        class="badge badge-warning">0</span></a>
                        </li>
                        <div class="text-right">
                            {{ Form::open(array('url' => 'companies/' . $companies->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Usuń', array('class' => 'btn btn-small btn-danger')) }}
                            {{ Form::close() }}
                            @if($companies->is_active == TRUE)
                                <a class="btn btn-small btn-warning"
                                   href="{{ URL::to('companies/disable/' . $companies->id) }}">Deaktywuj</a>
                            @else
                                <a class="btn btn-small btn-warning"
                                   href="{{ URL::to('companies/enable/' . $companies->id) }}">Aktywuj</a>
                            @endif
                        </div>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4></h4>

                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Nazwa</th>
                                    <td>{{ $companies->name }}</td>
                                </tr>
                                <tr>
                                    <th>NIP</th>
                                    <td>{{ $companies->tax_number }}</td>
                                </tr>
                                <tr>
                                    <th>Telefon</th>
                                    <td>{{ $companies->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Miasto</th>
                                    <td>{{ $companies->city }}</td>
                                </tr>
                                <tr>
                                    <th>Adres</th>
                                    <td>{{ $companies->billing_address }}</td>
                                </tr>
                                <tr>
                                    <th>Państwo</th>
                                    <td>{{ $companies->country }}</td>
                                </tr>
                                <tr>
                                    <th>Kod pocztowy</th>
                                    <td>{{ $companies->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Liczba pracowników</th>
                                    <td>{{ $companies->employees }}</td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $companies->fax }}</td>
                                </tr>
                                <tr height="100px">
                                    <th>Opis firmy</th>
                                    <td>{{ $companies->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $companies->is_active ? 'Yes' : 'No' }}</td>
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