
<!--/. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">

            <li>
                <a class="active-menu" href="#"><i class="fa fa-dashboard"></i>System<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::to('/') }}">Dashboard</a>
                        <a href="{{ route('settings') }}">Settings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-user"></i>Clients<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('clients') }}">List of clients<span class="label label-warning pull-right" style="margin-top:4px;background-color: #d1b603 !important;">{{ \App\Client::countClients() ? : 0 }}</span></a>
                        <a href="{{ route('employees') }}">Employees<span class="label label-primary pull-right" style="margin-top:4px">{{ \App\Employees::countEmployees() ? : 0 }}</span></a>
                        <a href="{{ route('contacts') }}">Contacts<span class="label label-default pull-right" style="margin-top:4px">{{ \App\Contacts::countContacts() ? : 0 }}</span></a>
                        <a href="{{ route('deals') }}">Deals<span class="label label-danger pull-right" style="margin-top:4px">{{ \App\Deals::countDeals() ? : 0 }}</span></a>
                        <a href="{{ route('companies') }}">Companies<span class="label label-success pull-right" style="margin-top:4px">{{ \App\Companies::countCompanies() ? : 0 }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-tasks"></i> Tasks<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('tasks') }}">List of tasks</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money"></i>Marketing<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('finances') }}">Finances</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-pencil-square-o"></i>Products<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products') }}">List of products</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-camera"></i>Projects<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products') }}">List of projects</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-caret-square-o-down"></i>Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products') }}">List of reports</a>
                        <a href="{{ route('charts') }}">Charts</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shopping-cart"></i> Sales<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('sales') }}">List of sales</a>
                        <a href="{{ route('invoices') }}">Invoices</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('reports') }}"><i class="fa fa-file-text"></i>Reports</a>
            </li>
            <li>
                <a href="{{ route('mailing') }}"><i class="fa fa-file-text"></i>Mailing</a>
            </li>
            <li>
                <a href="{{ route('files') }}"><i class="fa fa-folder-open"></i>Files</a>
            </li>
        </ul>

    </div>

</nav>
