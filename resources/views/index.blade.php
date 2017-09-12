@extends('layouts.base')

@section('title', 'Welcome in SoftCRM')

@section('caption', 'Welcome in SoftCRM')

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-green">
                <div class="panel-body">
                    <i class="fa fa-archive fa-5x"></i>
                    <h3>{{ \App\Client::countClients() ? : 0 }}</h3>
                </div>
                <a href="{{ route('clients') }}" style="text-decoration: none">
                    <div class="panel-footer back-footer-green">
                        All clients
                        <i class="fa fa-arrow-circle-right"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-blue">
                <div class="panel-body">
                    <i class="fa fa-dollar fa-5x"></i>
                    <h3>{{ \App\Tasks::countTasks() ? : 0 }} </h3>
                </div>
                <a href="#" style="text-decoration: none">
                    <div class="panel-footer back-footer-blue">
                        All tasks
                        <i class="fa fa-arrow-circle-right"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-red">
                <div class="panel-body">
                    <i class="fa fa fa-users fa-5x"></i>
                    <h3>{{ \App\Employees::countEmployees() ? : 0 }} </h3>
                </div>
                <a href="{{ route('employees') }}" style="text-decoration: none">
                    <div class="panel-footer back-footer-red">
                        All employees
                        <i class="fa fa-arrow-circle-right"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-primary text-center no-boder bg-color-brown">
                <div class="panel-body">
                    <i class="fa fa-shopping-cart fa-5x"></i>
                    <h3>{{ \App\Products::countProducts() ? : 0 }} </h3>
                </div>
                <a href="#" style="text-decoration: none">
                    <div class="panel-footer back-footer-brown">
                        All products
                        <i class="fa fa-arrow-circle-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection