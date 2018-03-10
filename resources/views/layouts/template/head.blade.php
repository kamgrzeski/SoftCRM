<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SoftCRM - @yield('title')</title>
    <!-- Bootstrap Styles-->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet"/>
    <!-- FontAwesome Styles-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Morris Chart Styles-->
    <link href="{{ asset('/js/morris/morris-0.4.3.min.css') }}" rel="stylesheet"/>
    <!-- Custom Styles-->
    <link href="{{ asset('/css/custom-styles.css') }}" rel="stylesheet"/>
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>

    <link rel="stylesheet" href="{{ asset('/css/sortable-theme-dark.css') }}" />
    <script src="{{ asset('/js/sortable.min.js') }}"></script>

    <script src="http://www.chartjs.org/dist/2.7.1/Chart.bundle.js"></script>
    <script src="http://www.chartjs.org/samples/latest/utils.js"></script>

    <!-- Validator JS-->
    <script src="{{ asset('/js/validator.js') }}"></script>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/img/favicon.ico') }}"/>

    <!-- Jquery for validator -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <div class="se-pre-con"></div>
    @if (Config::get('crm_settings.loading_circle') == 1)
    <style>
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
            filter: blur(0px) !important;
            -webkit-filter: blur(0px) !important;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url({{ asset("images/loader.gif") }}) center no-repeat #fff;
        }
    </style>
    <script>
        $(window).load(function () {
            $(".se-pre-con").delay(900).fadeOut("slow");
        });
    </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function () {
            $('#localclock').jsclock();
        });
    </script>
</head>



