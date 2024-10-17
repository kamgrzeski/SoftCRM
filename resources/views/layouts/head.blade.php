<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - SoftCRM</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

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
        @if(cache()->get('loadingCircle'))
            background: url({{ asset("images/loader.gif") }}) center no-repeat #fff;
    @endif
}
</style>

<div class="se-pre-con"></div>
<script>
    window.addEventListener('load', function() {
        setTimeout(function() {
            var preLoader = document.querySelector('.se-pre-con');
            if (preLoader) {
                preLoader.style.transition = 'opacity 0.5s';
                preLoader.style.opacity = '0';
                setTimeout(function() {
                    preLoader.style.display = 'none';
                }, 500);
            }
        }, 500);
    });

</script>
