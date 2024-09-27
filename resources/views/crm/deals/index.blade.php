@extends('layouts.base')

@section('caption', 'List of deals')

@section('title', 'List of deals')

@section('lyric', '')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('layouts.template.messages')

            <a href="{{ route('deals.create.form') }}">
                <button type="button" class="btn btn-primary btn active">Add deals</button>
            </a>
            <br><br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-keyboard-o" aria-hidden="true"></i> List of deals
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-sortable>
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Deal between company</th>
                                <th class="text-center">Start date</th>
                                <th class="text-center">End date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width:200px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deals as $key => $deal)
                                <tr class="odd gradeX">
                                    <td class="text-center">{{ $deal->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('companies.view', $deal->company->id) }}">{{ $deal->company->name }}</a>
                                    </td>
                                    <td class="text-center">{{ $deal->start_time }}</td>
                                    <td class="text-center">{{ $deal->end_time }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('deals.set.active', $deal) }}">
                                            @csrf
                                            <label class="switch">
                                                <input type="checkbox" onchange="this.form.submit()" @if($deal->is_active) checked @endif>
                                                    <span class="slider"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td class="text-right" style="text-align: center">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{ route('deals.view', $deal) }}">More information</a>
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('deals.update.form', $deal) }}">Edit</a></li>
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
                    {!! $deals->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
