@extends('layouts.base')

@section('caption', 'Add deals')

@section('title', 'Add deals')

@section('lyric', 'lorem ipsum')

@section('content')
    @if(count($dataOfDeals) == 0)
        <div class="alert alert-danger">
            <strong>Danger!</strong> There is no company in system. Please create one. <a
                    href="{{ URL::to('companies/create') }}">Click here!</a>
        </div>
    @endif
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

    <!-- /. ROW  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{ Form::open(array('route' => 'processCreateDeals')) }}
                            <div class="form-group input-row">
                                {{ Form::label('name', 'Name') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                                    {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('start_time', 'Start date') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {{ Form::date('start_time', \Carbon\Carbon::now(), array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('end_time', 'End date') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {{ Form::date('end_time', \Carbon\Carbon::now(), array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('companies_id', 'Deal between company:') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                                    {{ Form::select('companies_id', $dataOfDeals, null, ['class' => 'form-control', 'placeholder' => $inputText,
                                    'placeholder' => 'Please select companie'])  }}
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 validate_form">
                            {{ Form::submit('Add deal', array('class' => 'btn btn-primary')) }}
                        </div>
                    {{ Form::close() }}
                    <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <script>
            $(document).ready(function () {
                //create formValidator object
                //there are a lot of configuration options that need to be passed,
                //but this makes it extremely flexibility and doesn't make any assumptions
                var validator = new formValidator({
                    //this function adds an error message to a form field
                    addError: function (field, message) {
                        //get existing error message field
                        var error_message_field = $('.error_message', field.parent('.input-group'));

                        //if the error message field doesn't exist yet, add it
                        if (!error_message_field.length) {
                            error_message_field = $('<span/>').addClass('error_message');
                            field.parent('.input-group').append(error_message_field);
                        }

                        error_message_field.text(message).show(200);
                        field.addClass('error');
                    },
                    //this removes an error from a form field
                    removeError: function (field) {
                        $('.error_message', field.parent('.input-group')).text('').hide();
                        field.removeClass('error');
                    },
                    //this is a final callback after failing to validate one or more fields
                    //it can be used to display a summary message, scroll to the first error, etc.
                    onErrors: function (errors, event) {
                        //errors is an array of objects, each containing a 'field' and 'message' parameter
                    },
                    //this defines the actual validation rules
                    rules: {
                        //this is a basic non-empty check
                        'name': {
                            'field': $('input[name=name]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A name is required.";
                                }
                            }
                        },
                        'companies_id': {
                            'field': $('select[name=companies_id]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A companies is required.";
                                }
                            }
                        }
                    }
                });

                //now, we attach events

                //this does validation every time a field loses focus
                $('form').on('blur', 'input,select', function () {
                    validator.validateField($(this).attr('name'), 'blur');
                });

                //this clears errors every time a field gains focus
                $('form').on('focus', 'input,select', function () {
                    validator.clearError($(this).attr('name'));
                });

                //this is for the validate links
                $('.validate_section').click(function () {
                    var fields = [];
                    $('input,select', $(this).closest('.section')).each(function () {
                        fields.push($(this).attr('name'));
                    });

                    if (validator.validateFields(fields, 'submit')) {
                        alert('success');
                    }
                    return false;
                });
                $('.validate_form').click(function () {
                    if (!validator.validateFields('submit')) {
                        return false;
                    }
                    return true;
                });

                //this is for the clear links
                $('.clear_section').click(function () {
                    var fields = [];
                    $('input,select', $(this).closest('.section')).each(function () {
                        fields.push($(this).attr('name'));
                    });

                    validator.clearErrors(fields);
                    return false;
                });
            });
        </script>
@endsection