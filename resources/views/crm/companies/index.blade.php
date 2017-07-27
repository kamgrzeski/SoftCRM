@extends('layouts.base')

@section('caption', 'Companies')

@section('title', 'Companies')

@section('lyric', 'some text about Companies.')

@section('content')

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <p>
                <a href="{{ URL::to('companies/create') }}"><button type="button" class="btn btn-primary btn-lg active">Add Companies</button></a>
            </p>
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Companies list
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Tax numer</th>
                                <th>Tags</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $key => $value)
                                <tr class="odd gradeX">

                                <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->tax_number }}</td>
                                    <td>{{ $value->tags }}</td>
                                    <td>{{ $value->is_active ? 'Yes' : 'No' }}</td>

                                    <!-- we will also add show, edit, and delete buttons -->
                                    <td>
                                        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                                        <a class="btn btn-small btn-success" href="{{ URL::to('companies/' . $value->id) }}">Show this companies</a>

                                        <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                                        <a class="btn btn-small btn-info" href="{{ URL::to('companies/' . $value->id . '/edit') }}">Edit this companies</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!--End Advanced Tables -->
        </div>
    </div>
@endsection