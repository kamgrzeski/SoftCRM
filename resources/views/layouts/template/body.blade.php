<body>
<div id="wrapper">
    <nav class="navbar navbar-default top-navbar" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}"><i class="fa fa-comments"></i> SoftCRM</a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <span style="margin-right: 25px">
                <span class="clock">
                            {{ \Carbon\Carbon::now()->format('d F Y') }} |
            </span>
            <span id="localclock" class="clock"></span>
            </span>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    <img src="{{ asset('./images/avatar.png') }}"> Welcome {{{ auth()->user()->name }}} <i
                            class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    </li>
                    <li>
                        <a href="{{ route('settings') }}"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    <li>
                        <a href="{{ route('password-reset') }}"><i class="fa fa-gear fa-fw"></i> Password reset</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
