<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">

            <li>
                <a class="active-menu" href="#"><i class="fa fa-dashboard"></i>System<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url()->to('/') }}">Dashboard</a>
                        <a href="{{ route('settings.index') }}">Settings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-user"></i>Dependencies<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('clients.index') }}">Clients<span class="label label-dependencies pull-right" style="margin-top:4px;">{{ cache()->get('countClients') }}</span></a>
                        <a href="{{ route('employees.index') }}">Employees<span class="label label-dependencies pull-right" style="margin-top:4px">{{ cache()->get('countEmployees') }}</span></a>
                        <a href="{{ route('deals.index') }}">Deals<span class="label label-dependencies pull-right" style="margin-top:4px">{{ cache()->get('countDeals') }}</span></a>
                        <a href="{{ route('companies.index') }}">Companies<span class="label label-dependencies pull-right" style="margin-top:4px">{{ cache()->get('countCompanies') }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money"></i>Marketing<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products.index') }}">Products<span class="label label-marketing pull-right" style="margin-top:4px">{{ cache()->get('countProducts') }}</span></a>
                        <a href="{{ route('tasks.index') }}">Tasks<span class="label label-marketing pull-right" style="margin-top:4px">{{ cache()->get('countTasks') }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shopping-cart"></i> Sales<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('finances.index') }}">Finances<span class="label label-sales pull-right" style="margin-top:4px">{{ cache()->get('countFinances') }}</span></a>
                        <a href="{{ route('sales.index') }}">Sales<span class="label label-sales pull-right" style="margin-top:4px">{{ cache()->get('countSales') }}</span></a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul style="margin-top: 10px; color: #dee7f1;margin-left:-30px;font-size: 14px;"></a>
            <h4>Informations <a href="{{ route('reload.info') }}"><span class="refresh-info">Refresh</span></a></h4>
            <li><i class="fa fa-money" aria-hidden="true"></i> Today income:  {{ cache()->get('todayIncome') }}</li>
            <li><i class="fa fa-money" aria-hidden="true"></i> Yesterday income: {{ cache()->get('yesterdayIncome') }}</li>
            <li><i class="fa fa-money" aria-hidden="true"></i> Cash turnover:  {{ cache()->get('cashTurnover') }}</li>
            <br>
            <li><i class="fa fa-cogs" aria-hidden="true"></i> Operations: {{ cache()->get('countAllRowsInDb')  }}</li>
            <li><i class="fa fa-book" aria-hidden="true"></i> System logs: {{ cache()->get('countSystemLogs') }}</li>
        </ul>
    </div>
</nav>
