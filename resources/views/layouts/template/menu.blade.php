
<!--/. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">

            <li>
                <a class="active-menu" href="#"><i class="fa fa-dashboard"></i>System<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::to('/') }}">Panel główny</a>
                        <a href="#">Ustawienia</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-user"></i>Kliencie<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('clients') }}">Lista klientów</a>
                        <a href="{{ route('employees') }}">Pracownicy</a>
                        <a href="{{ route('contacts') }}">Kontakty</a>
                        <a href="{{ route('deals') }}">Umowy</a>
                        <a href="{{ route('companies') }}">Firmy</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-tasks"></i> Zadania<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('tasks') }}">List zadań</a>
                        <a href="{{ route('mailing') }}">Mailing</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money"></i>Marketing<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('finances') }}">Finansy</a>
                        <a href="{{ route('projects') }}">Projekty</a>
                        <a href="{{ route('invoices') }}">Faktury</a>
                        <a href="{{ route('charts') }}">Wykresy</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o"></i>Konta<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('accounts') }}">Lista kont</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-pencil-square-o"></i>Produkty<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('products') }}">Lista produktów</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shopping-cart"></i> Sprzedaż<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('sales') }}">Lista sprzedaży</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('reports') }}"><i class="fa fa-file-text"></i>Raporty</a>
            </li>
            <li>
                <a href="{{ route('calendar') }}"><i class="fa fa-calendar"></i>Kalendarz</a>
            </li>
            <li>
                <a href="{{ route('files') }}"><i class="fa fa-folder-open"></i>Pliki</a>
            </li>
        </ul>

    </div>

</nav>
