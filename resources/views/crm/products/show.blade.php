@extends('layouts.base')

@section('caption', 'Information about product')

@section('title', 'Information about product')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            @include('layouts.template.messages')
            <br/>
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal">
                                Delete this product <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>
                    <div class="tab-pane fade active in" id="home">
                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $product->category  }}</td>
                            </tr>
                            <tr>
                                <th>Count</th>
                                <td>{{ $product->count  }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{ $product->price  }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $product->is_active ? 'Active' : 'Deactivate' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

   @include('crm.products.modals.delete_product_modal')
@endsection
