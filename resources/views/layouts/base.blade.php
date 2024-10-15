<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

@include('layouts.template.header')

<body>

@if(cache()->get('loadingCircle'))
    <div class="se-pre-con"></div>
@endif

<div id="wrapper">
    @include('layouts.template.navbar')
    @include('layouts.template.menu')

    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                @yield('content')
            </div>

            @include('layouts.template.footer')
        </div>
    </div>
</div>

@include('layouts.template.scripts')

</body>

</html>
