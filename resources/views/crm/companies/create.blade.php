@extends('layouts.base')

@section('caption', 'Add companies')

@section('title', 'Add companies')

@section('lyric', '')

@section('content')
    @if(count($dataWithPluckOfClient) == 0)
        <div class="alert alert-danger">
            <strong>Danger!</strong> There is no  in system. Please create any client. <a href="{{ URL::to('client/create') }}">Click here!</a>
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
                            {{ Form::open(array('route' => 'companies')) }}
                            <div class="form-group input-row">
                                {{ Form::label('name', 'Name') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                                    {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('tax_number', 'Tax number') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-slack"></i></span>
                                    {{ Form::text('tax_number', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
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
                                {{ Form::label('city', 'City') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                    {{ Form::text('city', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('billing_address', 'Billing address') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                    {{ Form::text('billing_address', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('country', 'Country') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                    {{ Form::text('country', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('postal_code', 'Postal code') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                    {{ Form::text('postal_code', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div></div>

                            <div class="form-group input-row">
                                {{ Form::label('employees_size', 'Employee size') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-crop"></i></span>
                                    {{ Form::text('employees_size', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div></div>

                            <div class="form-group input-row">
                                {{ Form::label('fax', 'Fax number') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                    {{ Form::text('fax', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div></div>

                            <div class="form-group input-row">
                                {{ Form::label('client_id', 'Assign client') }}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                                    {{ Form::select('client_id', $dataWithPluckOfClient, null, ['class' => 'form-control', 'placeholder' => $inputText])  }}
                                </div>
                            </div>

                            <div class="form-group input-row">
                                {{ Form::label('description', 'Description') }}
                                {{ Form::textarea('description', null, array('class' => 'form-control', 'placeholder' => $inputText)) }}
                                </div>

                        </div>

                        <div class="col-lg-12 validate_form">
                            {{ Form::submit('Add companie', array('class' => 'btn btn-primary')) }}
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
            $(document).ready(function() {
                //create formValidator object
                //there are a lot of configuration options that need to be passed,
                //but this makes it extremely flexibility and doesn't make any assumptions
                var validator = new formValidator({
                    //this function adds an error message to a form field
                    addError: function(field, message) {
                        //get existing error message field
                        var error_message_field = $('.error_message',field.parent('.input-group'));

                        //if the error message field doesn't exist yet, add it
                        if(!error_message_field.length) {
                            error_message_field = $('<span/>').addClass('error_message');
                            field.parent('.input-group').append(error_message_field);
                        }

                        error_message_field.text(message).show(200);
                        field.addClass('error');
                    },
                    //this removes an error from a form field
                    removeError: function(field) {
                        $('.error_message',field.parent('.input-row')).text('').hide();
                        field.removeClass('error');
                    },
                    //this is a final callback after failing to validate one or more fields
                    //it can be used to display a summary message, scroll to the first error, etc.
                    onErrors: function(errors, event) {
                        //errors is an array of objects, each containing a 'field' and 'message' parameter
                    },
                    //this defines the actual validation rules
                    rules: {
                        //this is a basic non-empty check
                        'name': {
                            'field': $('input[name=name]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A name is required.";
                                }
                            }
                        },
                        'tax_number': {
                            'field': $('input[name=tax_number]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A tax number is required.";
                                }

                                var tax_pattern = /[0-9]$/i;
                                if (!tax_pattern.test(field.val())) {
                                    throw "Please enter a valid tax number.";
                                }
                            }
                        },
                        'city': {
                            'field': $('input[name=city]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A city is required.";
                                }
                            }
                        },
                        'billing_address': {
                            'field': $('input[name=billing_address]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A billing address is required.";
                                }
                            }
                        },
                        'country': {
                            'field': $('input[name=country]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A country is required.";
                                }
                            }
                        },
                        'postal_code': {
                            'field': $('input[name=postal_code]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A postal code is required.";
                                }

                                var postal_pattern = /[0-9]$/i;
                                if (!postal_pattern.test(field.val())) {
                                    throw "Please enter a valid postal number.";
                                }
                            }
                        },
                        'employees_size': {
                            'field': $('input[name=employees_size]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A employees size is required.";
                                }

                                var em_pattern = /[0-9]$/i;
                                if (!em_pattern.test(field.val())) {
                                    throw "Please enter a valid employee number.";
                                }
                            }
                        },
                        'fax': {
                            'field': $('input[name=fax]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A fax is required.";
                                }

                                var fax_pattern = /[0-9]$/i;
                                if (!fax_pattern.test(field.val())) {
                                    throw "Please enter a valid fax number.";
                                }
                            }
                        },
                        'description': {
                            'field': $('textarea[name=description]'),
                            'validate': function(field, event) {
                                if(!field.val()) {
                                    throw "A description is required.";
                                }
                            }
                        },
                        //this demonstrates more than one error message
                        //and handling more than one event
                        'phone': {
                            'field': $('input[name=phone]'),
                            'validate': function(field, event) {
                                //if the validation is fired from a blur event,
                                //don't throw any errors if it is empty

                                if (!field.val()) {
                                    throw "A phone number is required."

                                };

                                var phone_pattern = /[0-9]$/i;
                                if (!phone_pattern.test(field.val())) {
                                    throw "Please enter a valid phone number.";
                                }

                            }
                        }
                    }
                });

                //now, we attach events

                //this does validation every time a field loses focus
                $('form').on('blur','input,select',function() {
                    validator.validateField($(this).attr('name'),'blur');
                });

                //this clears errors every time a field gains focus
                $('form').on('focus','input,select',function() {
                    validator.clearError($(this).attr('name'));
                });

                //this is for the validate links
                $('.validate_section').click(function() {
                    var fields = [];
                    $('input,select',$(this).closest('.section')).each(function() {
                        fields.push($(this).attr('name'));
                    });

                    if(validator.validateFields(fields,'submit')) {
                        alert('success');
                    }
                    return false;
                });
                $('.validate_form').click(function() {
                    if(!validator.validateFields('submit')) {
                        return false;
                    }
                    return true;
                });

                //this is for the clear links
                $('.clear_section').click(function() {
                    var fields = [];
                    $('input,select',$(this).closest('.section')).each(function() {
                        fields.push($(this).attr('name'));
                    });

                    validator.clearErrors(fields);
                    return false;
                });
            });
        </script>
@endsection