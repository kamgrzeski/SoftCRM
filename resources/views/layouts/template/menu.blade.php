
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
                        <a href="{{ route('clients') }}">Clients<span class="label label-dependencies pull-right" style="margin-top:4px;">{{ \App\Models\ClientsModel::countClients() ? : 0 }}</span></a>
                        <a href="{{ route('employees') }}">Employees<span class="label label-dependencies pull-right" style="margin-top:4px">{{ \App\Models\EmployeesModel::countEmployees() ? : 0 }}</span></a>
                        <a href="{{ route('deals') }}">Deals<span class="label label-dependencies pull-right" style="margin-top:4px">{{ \App\Models\DealsModel::countDeals() ? : 0 }}</span></a>
                        <a href="{{ route('companies') }}">Companies<span class="label label-dependencies pull-right" style="margin-top:4px">{{ \App\Models\CompaniesModel::countCompanies() ? : 0 }}</span></a>
                        <a href="{{ route('contacts') }}">Contacts<span class="label label-dependencies pull-right" style="margin-top:4px">{{ \App\Models\ContactsModel::countContacts() ? : 0 }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money"></i>Marketing<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products') }}">Products<span class="label label-marketing pull-right" style="margin-top:4px">{{ \App\Models\ProductsModel::countProducts() ? : 0 }}</span></a>
                        <a href="{{ route('tasks') }}">Tasks<span class="label label-marketing pull-right" style="margin-top:4px">{{ \App\Models\TasksModel::countTasks() ? : 0 }}</span></a>
                        <a href="{{ route('projects') }}">Projects<span class="label label-marketing pull-right" style="margin-top:4px">{{ \App\Models\ProjectsModel::countProjects() ? : 0 }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shopping-cart"></i> Sales<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('invoices') }}">Invoices<span class="label label-sales pull-right" style="margin-top:4px">{{ \App\Models\InvoicesModel::countInvoices() ? : 0 }}</span></a>
                        <a href="{{ route('finances') }}">Finances<span class="label label-sales pull-right" style="margin-top:4px">{{ \App\Models\FinancesModel::countFinances() ? : 0 }}</span></a>
                        <a href="{{ route('sales') }}">Sales<span class="label label-sales pull-right" style="margin-top:4px">{{ \App\Models\SalesModel::countSales() ? : 0 }}</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money"></i>Mailing<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('mailing') }}">Mailing list<span class="label label-mailing pull-right" style="margin-top:4px">{{ \App\Models\MailingModel::countMailing() ? : 0 }}</span></a>
                        <a href="{{ route('mail_manager') }}">Mailing manager<span class="label label-mailing pull-right" style="background-color: red;font-size: 11px;margin-top:2px">NEW</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('files') }}"><i class="fa fa-folder-open"></i>Files<span class="label label-files pull-right" style="margin-top:4px">{{ \App\Models\FilesModel::countFiles() ? : 0 }}</span></a>
            </li>
        </ul>
        @if (Config::get('crm_settings.stats') == 1)
        <ul style="margin-top: 10px; color: #dee7f1;margin-left:-30px;font-size: 14px;">
            <h4>Informations</h4>
            <li><i class="fa fa-money" aria-hidden="true"></i> Today income:  {{ \App\Http\Controllers\DashboardController::countTodayIncome() }}</span></li>
            <li><i class="fa fa-money" aria-hidden="true"></i> Yesterday income: {{ \App\Http\Controllers\DashboardController::countYesterdayIncome() }}</li>
            <li><i class="fa fa-money" aria-hidden="true"></i> Cash turnover:  {{ \App\Http\Controllers\DashboardController::countCashTurnover() }}</li>
            <br>
            <li><i class="fa fa-file-text" aria-hidden="true"></i></i> Invoices: {{ \App\Models\InvoicesModel::countRows() ? : 0 }}</li>
            <li><i class="fa fa-envelope-o" aria-hidden="true"></i> Email sents: {{ \App\Models\MailingModel::countMailing() ? : 0 }}</li>
            <li><i class="fa fa-cogs" aria-hidden="true"></i> Operations: {{ \App\Http\Controllers\DashboardController::countAllRowsInDb() }}</li>
            <li><i class="fa fa-book" aria-hidden="true"></i> System logs: {{ \App\Models\SystemLogsModel::countRows() ? : 0 }}</li>
        </ul>
            @endif
    </div>

</nav>
