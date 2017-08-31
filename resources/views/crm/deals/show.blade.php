@extends('layouts.base')

@section('caption', 'Informacje o umowie')

@section('title', 'Informacje o umowie')

@section('lyric', 'Informacje o umowie')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            <!-- will be used to show any messages -->
            @if(session()->has('message_success'))
                <div class="alert alert-success">
                    <strong>Well done!</strong> {{ session()->get('message_success') }}
                </div>
            @elseif(session()->has('message_danger'))
                <div class="alert alert-danger">
                    <strong>Danger!</strong> {{ session()->get('message_danger') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    More information about {{ $deals->name }}
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">The basic information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Company <span
                                        class="badge badge-warning">{{ count($deals->companies) }}</span></a>
                        </li>
                        <li class="""><a href="#messages" data-toggle="tab">Terms of agreement <span
                                        class="badge badge-danger">VERY IMPORTANT</span></a>
                        </li>
                        <div class="text-right">
                            {{ Form::open(array('url' => 'deals/' . $deals->id, 'class' => 'pull-right')) }}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete this deals', array('class' => 'btn btn-small btn-danger')) }}
                            {{ Form::close() }}
                        </div>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4></h4>

                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Nazwa</th>
                                    <td>{{ $deals->name }}</td>
                                </tr>
                                <tr>
                                    <th>Umowa między firmą</th>
                                    <td>
                                        <a href="{{ URL::to('companies/' . $deals->companies->id) }}">{{ $deals->companies->name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Data rozpoczenia umowy</th>
                                    <td>{{ $deals->start_time }}</td>
                                </tr>
                                <tr>
                                    <th>Data zakończenia umowy</th>
                                    <td>{{ $deals->end_time }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $deals->is_active ? 'Yes' : 'No' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <p> <table class="table table-striped table-bordered">
                                <h4>Pełne informacje o <strong>{{ $deals->companies->name }}</strong></h4><br>
                                <tbody class="text-right">
                                <tr>
                                    <th>Nazwa</th>
                                    <td>{{ $deals->companies->name }}</td>
                                </tr>
                                <tr>
                                    <th>NIP</th>
                                    <td>{{ $deals->companies->tax_number }}</td>
                                </tr>
                                <tr>
                                    <th>Telefon</th>
                                    <td>{{ $deals->companies->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Miasto</th>
                                    <td>{{ $deals->companies->city }}</td>
                                </tr>
                                <tr>
                                    <th>Adres</th>
                                    <td>{{ $deals->companies->billing_address }}</td>
                                </tr>
                                <tr>
                                    <th>Państwo</th>
                                    <td>{{ $deals->companies->country }}</td>
                                </tr>
                                <tr>
                                    <th>Kod pocztowy</th>
                                    <td>{{ $deals->companies->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Liczba pracowników</th>
                                    <td>{{ $deals->companies->employees }}</td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $deals->companies->fax }}</td>
                                </tr>
                                <tr height="100px">
                                    <th>Opis firmy</th>
                                    <td>{{ $deals->companies->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $deals->companies->is_active ? 'Yes' : 'No' }}</td>
                                </tr>
                                </tbody>
                            </table></p>
                        </div>
                        <div class="tab-pane fade" id="messages">
                            <h4>Warunki umowy</h4>
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