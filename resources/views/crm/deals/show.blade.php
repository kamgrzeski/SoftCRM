@extends('layouts.base')

@section('caption', 'Information about deals')
@section('title', 'Information about deals')
@section('lyric', 'Information about deals')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-6">

            @include('layouts.template.messages')

            <div class="panel panel-default">
                <div class="panel-heading">
                       Deal details
                </div>

                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">The basic information</a>
                        </li>
                        <li class=""><a href="#profile" data-toggle="tab">Company</a>
                        </li>
                        <li class=""><a href="#storeDealTerm" data-toggle="tab">Terms of agreement <span class="badge badge-danger">VERY IMPORTANT</span></a>
                        </li>
                        <div class="text-right">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteDealTermModal">
                                Delete this deal <li class="fa fa-trash-o"></li>
                            </button>
                        </div>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="home">


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
                                    <td>{{ $deal->is_active ? 'Active' : 'Deactivate' }}</td>
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
                        <div class="tab-pane fade" id="storeDealTerm">
                            @include('crm.deals.forms.store_deal')
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
                            @foreach($deal->dealTerms as $key => $terms)
                                <tr>
                            <th scope="row">{{ $terms->id }}</th>
                            <td>{{ $terms->created_at }}</td>
                            <td>
                                @include('crm.deals.forms.delete_deal')
                                @include('crm.deals.forms.generate_pdf')
                            </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane fade">
                    @include('crm.deals.forms.store_deal_term')
                </div>
            </div>
        </div>
    </div>

    @include('crm.deals.modals.delete_deal_term_modal')

    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'summary-ckeditor' );
    </script>
@endsection
