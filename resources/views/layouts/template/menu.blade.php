
<!--/. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">

            <li>
                <a class="active-menu" href="#"><i class="fa fa-dashboard"></i>System<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('home') }}">Dashboard</a>
                        <a href="#">Settings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-desktop"></i>Clients<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('clients') }}">Clients list</a>
                        <a href="{{ route('employees') }}">Employees</a>
                        <a href="{{ route('contacts') }}">Contacts</a>
                        <a href="{{ route('deals') }}">Deals</a>
                        <a href="{{ route('companies') }}">Companies</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-table"></i> Tasks<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('tasks') }}">Tasks list</a>
                        <a href="{{ route('mailing') }}">Mailing</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-desktop"></i>Marketing<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('finances') }}">Finances</a>
                        <a href="{{ route('projects') }}">Projects</a>
                        <a href="{{ route('invoices') }}">Invoices</a>
                        <a href="{{ route('charts') }}">Charts</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i>Accounts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('accounts') }}">Account list</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i>Products<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products') }}">Product list</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-qrcode"></i> Sales<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('sales') }}">Sales list</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('reports') }}"><i class="fa fa-desktop"></i>Reports</a>
            </li>
            <li>
                <a href="{{ route('calendar') }}"><i class="fa fa-desktop"></i>Calendar</a>
            </li>
            <li>
                <a href="{{ route('files') }}"><i class="fa fa-desktop"></i>Files</a>
            </li>
        </ul>

    </div>

</nav>
