@extends('layouts.base')

@section('caption', 'Add client')

@section('title', 'Add client')

@section('lyric', 'lorem ipsum')

@section('content')

    @include('layouts.template.messages')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('crm.clients.forms.store_client_form')
                </div>
            </div>
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
                        //errors is an  of objects, each containing a 'field' and 'message' parameter
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

                        //this demonstrates more than one error message
                        //and handling more than one event
                        'budget': {
                            'field': $('input[name=budget]'),
                            'validate': function (field, event) {
                                //if the validation is fired from a blur event,
                                //don't throw any errors if it is empty

                                if (!field.val()) {
                                    throw "A budget is required."

                                }
                                ;

                                var phone_pattern = /[0-9]$/i;
                                if (!phone_pattern.test(field.val())) {
                                    throw "Please enter only number.";
                                }

                            }
                        },

                        //this demonstrates more than one error message
                        //and handling more than one event
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
                        },
                        'city': {
                            'field': $('input[name=city]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A city is required.";
                                }
                            }
                        },

                        'country': {
                            'field': $('input[name=country]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A country is required.";
                                }
                            }
                        },
                        'location': {
                            'field': $('input[name=location]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A location is required.";
                                }
                            }
                        },
                        'zip': {
                            'field': $('input[name=zip]'),
                            'validate': function (field, event) {
                                if (!field.val()) {
                                    throw "A zip is required.";
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
    </div>
@endsection
