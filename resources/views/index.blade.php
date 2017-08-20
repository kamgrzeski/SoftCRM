@extends('layouts.base')

@section('title', 'Panel główny')

@section('caption', 'Panel główny')

@section('lyric', 'some text about dashboard')

@section('content')
    <p>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-green">
                <div class="panel-body">
                    <i class="fa fa-archive fa-5x"></i>
                    <h3>{{ \App\Companies::countCompanies() ? : 0 }}</h3>
                </div>
                <div class="panel-footer back-footer-green">
                    Firm

                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-blue">
                <div class="panel-body">
                    <i class="fa fa-dollar fa-5x"></i>
                    <h3>{{ \App\Sales::countSales() ? : 0 }} </h3>
                </div>
                <div class="panel-footer back-footer-blue">
                    Przychodów

                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-red">
                <div class="panel-body">
                    <i class="fa fa fa-users fa-5x"></i>
                    <h3>{{ \App\Employees::countEmployees() ? : 0 }} </h3>
                </div>
                <div class="panel-footer back-footer-red">
                    Pracowników

                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="panel-body">
                    <i class="fa fa-user fa-5x"></i>
                    <h3>{{ \App\Client::countClients() }} </h3>
                </div>
                <div class="panel-footer back-footer-brown">
                    Klientów

                </div>
            </div>
        </div>
    </div>
    </p>
@endsection