@extends('layouts.base')

@section('caption', 'Mail manager')

@section('title', 'Mail manager')

@section('content')
    <div class="row">`
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> Mail Manager panel
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emailsQuery as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->name }}</td>
                                    <td class="text-center">{{ $value->stat->name }}</td>
                                    <td class="text-center"></td>
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