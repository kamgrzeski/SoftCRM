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
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clientEmails as $key => $value)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $value->email }}</td>
                                    <td>
                                        {{ Form::open(array('url' => 'client/' . $value->id, 'class' => 'pull-right')) }}
                                        {{ Form::hidden('_method', 'GET') }}
                                        {{ Form::submit('Go to client with this email', array('class' => 'btn btn-primary btn-sm')) }}
                                        {{ Form::close() }}

                                        <!-- Trigger the modal with a button -->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" style="align:right" data-target="#myModal">Send email</button>

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
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send email to this client</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => '/mailing/send/' . $value->id)) }}
                    {{ Form::hidden('_method', 'POST') }}
                    {{ Form::text('username') }}
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" type="textarea" id="message" placeholder="Message" maxlength="140" rows="7"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    {{ Form::submit('Add send email to query', array('class' => 'btn btn-success')) }}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {{ Form::close() }}

            </div>

        </div>
    </div>
@endsection