@extends('layouts.base')

@section('caption', 'Information about product')

@section('title', 'Information about product')


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
            <br/>
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                Delete this product <li class="fa fa-trash-o"></li>
                            </button>
                        </div>

                    </ul>
                    <div class="tab-pane fade active in" id="home">
                        <h4></h4>

                        <table class="table table-striped table-bordered">
                            <tbody class="text-right">
                            <tr>
                                <th>Name</th>
                                <td>{{ $products->name }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $products->category  }}</td>
                            </tr>
                            <tr>
                                <th>Count</th>
                                <td>{{ $products->count  }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{ $products->price  }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $products->is_active ? 'Yes' : 'No' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">You want delete this products?</h4>
                </div>
                <div class="modal-body">
                    Action will delete permanently this products.
                </div>
                <div class="modal-footer">
                    {{ Form::open(array('url' => 'products/delete/' . $products->id, 'class' => 'pull-right')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete this product', array('class' => 'btn btn-small btn-danger')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection