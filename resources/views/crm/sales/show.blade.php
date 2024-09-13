@extends('layouts.base')

@section('caption', 'Information about sales')

@section('title', 'Information about sales')

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
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteSaleModal">
                                Delete this sale <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>
                    <div class="tab-pane fade active in" id="home">
                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Name</th>
                                <td>{{ $sale->name }}</td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td>{{ $sale->quantity }}</td>
                            </tr>
                            <tr>
                                <th>Date of payment</th>
                                <td>{{ $sale->date_of_payment }}</td>
                            </tr>
                            <tr>
                                <th>Assigned Product</th>
                                <td>
                                    <a href="{{ url()->to('products/view/' . $sale->products->id) }}">{{ $sale->products->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $sale->is_active ? 'Active' : 'Deactivate' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('crm.sales.modals.delete_sale_modal')
@endsection
