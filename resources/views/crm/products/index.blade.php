@extends('layouts.base')

@section('caption', 'List of products')

@section('title', 'List of products')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')
            <a href="{{ URL::to('products/form/create') }}">
                <button type="button" class="btn btn-primary btn active">Add products</button>
            </a>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of products
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example"
                               data-sortable>
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
                            @foreach($products as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->category }}</td>
                                    <td class="text-center">{{ $value->count }}</td>
                                    <td class="text-center">
                                        <button type="submit"
                                                class="btn btn-default">{{ Cknow\Money\Money::{App\Models\SettingsModel::getSettingValue('currency')}($value->price) }}</button>
                                    </td>
                                    <td class="text-center">
                                        @if($value->is_active)
                                            <label class="switch">
                                                <input type="checkbox"
                                                       onchange='window.location.assign("{{ URL::to('products/set-active/' . $value->id . '/0') }}")'
                                                       checked>
                                                <span class="slider"></span>
                                            </label>
                                        @else
                                            <label class="switch">
                                                <input type="checkbox"
                                                       onchange='window.location.assign("{{ URL::to('products/set-active/' . $value->id . '/1') }}")'>
                                                <span class="slider"></span>
                                            </label>
                                        @endif
                                    </td>
                                    <td class="text-right" style="text-align: center">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{ URL::to('products/view/' . $value->id) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span
                                                        class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ URL::to('products/form/update/' . $value->id) }}">Edit</a>
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
