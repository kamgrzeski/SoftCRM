<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SoftCRM - @yield('title')</title>
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ asset('/js/morris/morris-0.4.3.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/custom-styles.css') }}" rel="stylesheet"/>
    <script src="{{ asset('/js/sortable.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/sortable-theme-dark.css') }}"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
    <script src="http://www.chartjs.org/dist/2.7.1/Chart.bundle.js"></script>
    <script src="http://www.chartjs.org/samples/latest/utils.js"></script>
    <script src="{{ asset('/js/validator.js') }}"></script>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/favicon.ico') }}"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
    <div class="se-pre-con"></div>
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
            @if(\App\Models\SettingsModel::where('key', 'loading_circle')->get()->last()->value)
                background: url({{ asset("images/loader.gif") }}) center no-repeat #fff;
            @endif
        }
    </style>
    <script>
        $(window).load(function () {
            $(".se-pre-con").delay(500).fadeOut("slow");
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#localclock').jsclock();
        });

        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                "paging": false,
                "ordering": true,
                "info": false
            });
            $('#dataTables-example-sort-employees').DataTable({
                "paging": false,
                "ordering": true,
                "info": false
            });
        });
    </script>
</head>



