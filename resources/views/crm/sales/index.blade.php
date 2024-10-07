@extends('layouts.base')

@section('caption', 'List of sales')

@section('title', 'List of sales')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ route('sales.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add sales</button>
            </a>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of sales
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Date of Payment</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $key => $sale)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $sale->name }}</td>
                                    <td class="text-center">{{ $sale->quantity }}</td>
                                    <td class="text-center">
                                        <button type="submit"class="btn btn-default">
                                            {{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}
                                            ($sale->quantity * $sale->product->price) }}
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('products.view', $sale->product) }}">{{ $sale->product->name }}</a>
                                    </td>
                                    <td class="text-center">{{ $sale->date_of_payment }}</td>
                                    <td class="text-center">
                                    <form method="POST" action="{{ route('sales.set.active', $sale) }}">
                                    @csrf
                                        <label class="switch">
                                            <input type="checkbox" onchange="this.form.submit()" @if($sale->is_active) checked @endif>
                                                <span class="slider"></span>
                                        </label>
                                    </form>
                                    </td>
                                    <td class="text-right" style="text-align: center">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{ route('sales.view', $sale) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('sales.update.form', $sale) }}">Edit</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Some option</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $sales->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
