<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

@include('layouts.template.header')

<body>
<div id="wrapper">
    @include('layouts.template.navbar')
    @include('layouts.template.menu')
    <div id="page-wrapper">
        <div id="page-inner">
            @include('layouts.template.title')
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
