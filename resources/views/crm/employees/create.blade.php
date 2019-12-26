@extends('layouts.base')

@section('caption', 'Add empoloyees')

@section('title', 'Add empoloyees')

@section('lyric', 'lorem ipsum')

@section('content')
    @if(count($dataOfClients) == 0)
        <div class="alert alert-danger">
            <strong>Danger!</strong> There is no client in system. Please create one. <a
                    href="{{ URL::to('client/create') }}">Click here!</a>
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
                            {{ Form::open(array('route' => 'processCreateEmployee')) }}
                            <div class="form-group input-row">
                                {{ Form::label('full_name', 'Full name') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                                    {{ Form::text('full_name', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('phone', 'Phone') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
                                    {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('email', 'Email') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                    {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('job', 'Job') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                    {{ Form::text('job', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('client_id', 'Assign client') }}
                                <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                                {{ Form::select('client_id', $dataOfClients, null, ['class' => 'form-control', 'placeholder' => $inputText])  }}
                            </div>
                        </div>

                            <div class="form-group input-row">
                                {{ Form::label('note', 'Note') }}
                                {{ Form::textarea('note', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                            </div>
                        </div>

                        <div class="col-lg-12 validate_form">
                            {{ Form::submit('Add employee', array('class' => 'btn btn-primary')) }}
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
                        'full_name': {
                            'field': $('input[name=full_name]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A full name is required.";
                                }
                            }
                        },
                        'job': {
                            'field': $('input[name=job]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A job is required.";
                                }
                            }
                        },
                        'note': {
                            'field': $('textarea[name=note]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A note is required.";
                                }
                            }
                        },
                        'client_id': {
                            'field': $('select[name=client_id]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A client is required.";
                                }
                            }
                        },
                        'phone': {
                            'field': $('input[name=phone]'),
                            'validate': function (field, event) {
                                //if the validation is fired from a blur event,
                                //don't throw any errors if it is empty

                                if (!field.val()) {
                                    throw "A phone number is required."

                                }
                                ;

                                var phone_pattern = /[0-9]$/i;
                                if (!phone_pattern.test(field.val())) {
                                    throw "Please enter a valid phone number.";
                                }

                            }
                        },

                        'email': {
                            'field': $('input[name=email]'),
                            'validate': function (field, event) {
                                //if the validation is fired from a blur event,
                                //don't throw any errors if it is empty
                                if (event === 'blur' && !field.val()) field.addClass('success');

                                if (!field.val()) throw "A email is required.";

                                var email_pattern = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                                if (!email_pattern.test(field.val())) {
                                    throw "Please enter a valid email.";
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