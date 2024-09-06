@extends('layouts.base')

@section('caption', 'Settings')

@section('title', 'Settings')

@section('content')

    @include('layouts.template.errors')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        {{ Form::open(['route' => 'settings.update', 'method' => 'PUT']) }}
                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('pagination_size', 'Pagination size') }}
                                {{ Form::text('pagination_size', $settings['pagination_size'], ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group input-row">
                                {{ Form::label('priority_size', 'Priority size') }}
                                {{ Form::text('priority_size', $settings['priority_size'], ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group input-row">
                                {{ Form::label('loading_circle', 'Loading circle') }}
                                {{ Form::select('loading_circle', [1 => 'Show', 0 =>'Don\'t show'], $settings['loading_circle'], ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group input-row">
                                {{ Form::label('currency', 'Currency type') }}
                                {{ Form::select('currency', ['PLN' => 'PLN', 'EUR' => 'EUR', 'USD' => 'USD'], $settings['currency'], ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group input-row">
                                {{ Form::label('invoice_tax', 'Tax') }}
                                {{ Form::text('invoice_tax', $settings['invoice_tax'], ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-12 validate_form">
                            {{ Form::submit('Save settings', ['class' => 'btn btn-primary']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>System logs</h4>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>User Id</th>
                                    <th>Action</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>IP Address</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logsPaginate as $key => $value)
                                    <tr class="active">
                                        <td>{{ $value['user_id'] }}</td>
                                        <td>{{ $value['actions'] }}</td>
                                        <td>{{ $value['city'] }}</td>
                                        <td>{{ $value['country'] }}</td>
                                        <td>{{ $value['ip_address'] }}</td>
                                        <td>{{ $value['date'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {!! $logsPaginate->render() !!}
                </div>
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
                        var error_message_field = $('.error_message', field.parent('.input-row'));

                        //if the error message field doesn't exist yet, add it
                        if (!error_message_field.length) {
                            error_message_field = $('<span/>').addClass('error_message');
                            field.parent('.input-row').append(error_message_field);
                        }

                        error_message_field.text(message).show(200);
                        field.addClass('error');
                    },
                    //this removes an error from a form field
                    removeError: function (field) {
                        $('.error_message', field.parent('.input-row')).text('').hide();
                        field.removeClass('error');
                    },
                    //this is a final callback after failing to validate one or more fields
                    //it can be used to display a summary message, scroll to the first error, etc.
                    onErrors: function (errors, event) {
                        //errors is an array of objects, each containing a 'field' and 'message' parameter
                    },
                    //this defines the actual validation rules
                    rules: {
                        'pagination_size': {
                            'field': $('input[name=pagination_size]'),
                            'validate': function (field, event) {
                                //if the validation is fired from a blur event,
                                //don't throw any errors if it is empty

                                if (!field.val()) {
                                    throw "A pagination size is required."

                                }
                                ;

                                var pagination_pattern = /[0-9]$/i;
                                if (!pagination_pattern.test(field.val())) {
                                    throw "A pagination must be integer.";
                                }

                            }
                        },
                        'priority_size': {
                            'field': $('input[name=priority_size]'),
                            'validate': function (field, event) {
                                //if the validation is fired from a blur event,
                                //don't throw any errors if it is empty

                                if (!field.val()) {
                                    throw "A priority size is required."

                                }
                                ;

                                var priority_pattern = /[0-9]$/i;
                                if (!priority_pattern.test(field.val())) {
                                    throw "A priority must be integer.";
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
