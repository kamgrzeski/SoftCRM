@extends('layouts.base')

@section('caption', 'List of products')

@section('title', 'List of products')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ route('products.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add products</button>
            </a>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of products
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Count</th>
                                <th class="text-center">Price Util</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $key => $product)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $product->name }}</td>
                                    <td class="text-center">{{ $product->category }}</td>
                                    <td class="text-center">{{ $product->count }}</td>
                                    <td class="text-center">
                                        <button type="submit"
                                                class="btn btn-default">{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($product->price) }}</button>
                                    </td>
                                    <td class="text-center">
                                    <form method="POST" action="{{ route('products.set.active', $product) }}">
                                        @csrf
                                        <label class="switch">
                                            <input type="checkbox" onchange="this.form.submit()" @if($product->is_active) checked @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </form>
                                    </td>
                                    <td class="text-right" style="text-align: center">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{ route('products.view', $product) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span
                                                        class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('products.update.form', $product) }}">Edit</a>
                                                </li>
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
                    {!! $products->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
