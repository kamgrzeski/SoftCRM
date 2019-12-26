@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 personal-info">
            <h3>Personal info</h3>
            <br/>
            <form class="form-horizontal" method="POST" action="{{ route('profile') }}">
                 {{ csrf_field() }}
                 @if (isset($errors) && count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <div class="form-group">
                    <label class="col-lg-3 control-label">Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="{{$user->name}}" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" value="" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirm password:</label>
                    <div class="col-md-8">
                        <input class="form-control" type="password" value="" name="password_confirmed">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
