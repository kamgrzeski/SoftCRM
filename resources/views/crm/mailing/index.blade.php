@extends('layouts.base')

@section('caption', 'List of mailing')

@section('title', 'List of mailing')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of mailing
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clientEmails as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->email }}</td>
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