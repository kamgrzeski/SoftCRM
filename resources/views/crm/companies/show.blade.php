@extends('layouts.base')

@section('caption', 'Show company')

@section('title', 'show company')

@section('lyric', 'show company')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    More information about {{ $companies->name }}
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Fundamental information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Clients</a>
                        </li>
                        <li class=""><a href="#messages" data-toggle="tab">Employees</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4>{{ $companies->name }}</h4>
                            <p>
                                <strong>Name:</strong> {{ $companies->name }}<br>
                                <strong>Tax number:</strong> {{ $companies->tax_number }}<br>
                                <strong>Tags:</strong> {{ $companies->tags }}<br>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <h4>Profile Tab</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                        <div class="tab-pane fade" id="messages">
                            <h4>Messages Tab</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection