<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SoftCRM - @yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/favicon.ico') }}"/>

    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ asset('/css/custom-styles.css') }}" rel="stylesheet"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css"/>

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
            $('#dataTables').DataTable({
                "paging": false,
                "ordering": true,
                "info": false
            });
        });
    </script>
</head>



