
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
                <a href="#"><i class="fa fa-user"></i>Dependencies<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('clients') }}">Clients<span class="label label-dependencies pull-right" style="margin-top:4px;">{{ $countClients }}</span></a>
                        <a href="{{ route('employees') }}">Employees<span class="label label-dependencies pull-right" style="margin-top:4px">{{ $countEmployees }}</span></a>
                        <a href="{{ route('deals') }}">Deals<span class="label label-dependencies pull-right" style="margin-top:4px">{{ $countDeals }}</span></a>
                        <a href="{{ route('companies') }}">Companies<span class="label label-dependencies pull-right" style="margin-top:4px">{{ $countCompanies }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money"></i>Marketing<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products') }}">Products<span class="label label-marketing pull-right" style="margin-top:4px">{{ $countProducts }}</span></a>
                        <a href="{{ route('tasks') }}">Tasks<span class="label label-marketing pull-right" style="margin-top:4px">{{ $countTasks }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shopping-cart"></i> Sales<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('finances') }}">Finances<span class="label label-sales pull-right" style="margin-top:4px">{{ $countFinances }}</span></a>
                        <a href="{{ route('sales') }}">Sales<span class="label label-sales pull-right" style="margin-top:4px">{{ $countSales }}</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        @if (Config::get('crm_settings.stats') == 1)
        <ul style="margin-top: 10px; color: #dee7f1;margin-left:-30px;font-size: 14px;">
            <h4>Informations</h4>
            <li><i class="fa fa-money" aria-hidden="true"></i> Today income:  {{ $todayIncome }}</li>
            <li><i class="fa fa-money" aria-hidden="true"></i> Yesterday income: {{ $yesterdayIncome }}</li>
            <li><i class="fa fa-money" aria-hidden="true"></i> Cash turnover:  {{ $cashTurnover }}</li>
            <br>
            <li><i class="fa fa-cogs" aria-hidden="true"></i> Operations: {{ $countAllRowsInDb  }}</li>
            <li><i class="fa fa-book" aria-hidden="true"></i> System logs: {{ $countSystemLogs }}</li>
        </ul>
            @endif
    </div>

</nav>
