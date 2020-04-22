@extends('layouts.base')

@section('caption', 'Information about deals')

@section('title', 'Information about deals')

@section('lyric', 'Information about deals')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">
            @if(session()->has('message_success'))
                <div class="alert alert-success">
                    <strong>Well done!</strong> {{ session()->get('message_success') }}
                </div>
            @elseif(session()->has('message_danger'))
                <div class="alert alert-danger">
                    <strong>Danger!</strong> {{ session()->get('message_danger') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                       Stored deals terms
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">The basic information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Company</a>
                        </li>
                        <li class=""><a href="#messages" data-toggle="tab">Terms of agreement <span
                                        class="badge badge-danger">VERY IMPORTANT</span></a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                Delete this deal <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">
                            <h4></h4>

                            <table class="table table-striped table-bordered">
                                <tbody class="text-right">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $deal->name }}</td>
                                </tr>
                                <tr>
                                    <th>Deal between company</th>
                                    <td>
                                        <a href="{{ URL::to('companies/view/' . $deal->companies->id) }}">{{ $deal->companies->name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Start date</th>
                                    <td>{{ $deal->start_time }}</td>
                                </tr>
                                <tr>
                                    <th>End date</th>
                                    <td>{{ $deal->end_time }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $deal->is_active ? 'Yes' : 'No' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <p>
                            <table class="table table-striped table-bordered">
                                <h4>Full information about <strong>{{ $deal->companies->name }}</strong></h4><br>
                                <tbody class="text-right">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $deal->companies->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tax number</th>
                                    <td>{{ $deal->companies->tax_number }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $deal->companies->phone }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $deal->companies->city }}</td>
                                </tr>
                                <tr>
                                    <th>Billing address</th>
                                    <td>{{ $deal->companies->billing_address }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $deal->companies->country }}</td>
                                </tr>
                                <tr>
                                    <th>Postal code</th>
                                    <td>{{ $deal->companies->postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Employees size</th>
                                    <td>{{ $deal->companies->employees_size }}</td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $deal->companies->fax }}</td>
                                </tr>
                                <tr height="100px">
                                    <th>Description</th>
                                    <td>{{ $deal->companies->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $deal->companies->is_active ? 'Yes' : 'No' }}</td>
                                </tr>
                                </tbody>
                            </table>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="messages">
                            {{ Form::open(['route' => 'processStoreDealTerms']) }}

                            <div class="col-lg-12 editor-style">
                                    {!! Form::textarea('body', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                   incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                   exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                   dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                   Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                   mollit anim id est laborum.', ['class' => 'form-control', 'id' => 'summary-ckeditor']) !!}
                            </div>

                            {{ Form::hidden('dealId', $deal->id) }}

                            <div class="col-lg-12 validate_form" style="margin-top: 30px">
                                {{ Form::submit('Save terms of argeement', ['class' => 'btn btn-primary']) }}
                            </div>

                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Stored deals terms
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Created at</th>
                            <th scope="col" width="20%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($dealsTerms as $key => $terms)
                                <tr>
                            <th scope="row">{{ $terms->id }}</th>
                            <td>{{ $terms->formattedDate }}</td>
                            <td>

                                {{ Form::open(['url' => 'deals/terms/delete/', 'class' => 'pull-right']) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::hidden('termId', $terms->id) }}
                                {{ Form::submit('Delete', ['class' => 'btn btn-small btn-danger btn-padding']) }}
                                {{ Form::close() }}

                                {{ Form::open(['url' => 'deals/terms/generate-pdf/', 'class' => 'pull-right']) }}
                                {{ Form::hidden('_method', 'POST') }}
                                {{ Form::hidden('termId', $terms->id) }}
                                {{ Form::submit('Generate PDF', ['class' => 'btn btn-small btn-padding btn-pdf']) }}
                                {{ Form::close() }}
                            </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane fade" id="messages">
                    {{ Form::open(['route' => 'processStoreDealTerms']) }}

                    <div class="col-lg-12 editor-style">
                        {!! Form::textarea('body', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                       incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                       exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                       dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                       Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                       mollit anim id est laborum.', ['class' => 'form-control', 'id' => 'summary-ckeditor']) !!}
                    </div>

                    {{ Form::hidden('dealId', $deal->id) }}

                    <div class="col-lg-12 validate_form">
                        {{ Form::submit('Save terms of argeement', ['class' => 'btn btn-primary']) }}
                    </div>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">You want delete this deal?</h4>
                </div>
                <div class="modal-body">
                    Ation will delete permanently this deal.
                </div>
                <div class="modal-footer">
                    {{ Form::open(['url' => 'deals/delete/' . $deal->id,'class' => 'pull-right']) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete this deal', ['class' => 'btn btn-small btn-danger']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'summary-ckeditor' );
    </script>
@endsection