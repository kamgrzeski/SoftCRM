<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white transform transition-transform duration-200 ease-in-out z-50 md:static md:translate-x-0">
    <div class="p-3 text-3xl font-bold flex items-center">
        <i class="fas fa-user-shield mr-2"></i> SoftCRM
    </div>
    <nav class="flex-1 overflow-y-auto border-t border-gray-700 mt-1">
        <ul>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-tachometer-alt mr-3"></i>
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-users mr-3"></i>
                <a href="{{ route('clients.index') }}">
                    <span>Clients</span>
                    <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ cache()->get('countClients') }}</span>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-cog mr-3"></i>
                <a href="{{ route('employees.index') }}">
                    <span>Employees</span>
                    <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ cache()->get('countEmployees') }}</span>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-chart-line mr-3"></i>
                <a href="{{ route('deals.index') }}">
                    <span>Deals</span>
                    <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ cache()->get('countDeals') }}</span>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-file-alt mr-3"></i>
                <a href="{{ route('companies.index') }}">
                    <span>Companies</span>
                    <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ cache()->get('countCompanies') }}</span>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-file-alt mr-3"></i>
                <a href="{{ route('products.index') }}">
                    <span>Products</span>
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ cache()->get('countProducts') }}</span>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-file-alt mr-3"></i>
                <a href="{{ route('tasks.index') }}">
                    <span>Tasks</span>
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ cache()->get('countTasks') }}</span>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-file-alt mr-3"></i>
                <a href="{{ route('finances.index') }}">
                    <span>Finances</span>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ cache()->get('countFinances') }}</span>
                </a>
            </li>
            <li class="p-4 hover:bg-gray-700 flex items-center border-b border-gray-700">
                <i class="fas fa-file-alt mr-3"></i>
                <a href="{{ route('sales.index') }}">
                    <span>Sales</span>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ">{{ cache()->get('countSales') }}</span>
                </a>
            </li>
        </ul>

        <ul class="mt-2 text-[#dee7f1] ml-3 text-sm">
            <li class="text-lg font-semibold mb-3 mt-4">
                Information's
                <a href="{{ route('reload.info') }}" class="text-blue-400 hover:text-blue-600">

                    <button
                        onclick="window.location.href='{{ route('reload.info') }}'"
                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                        Refresh
                    </button>
                </a>
            </li>

            <li class="flex items-center mt-1">
                <i class="fa fa-book mr-2" aria-hidden="true"></i>
                Today income: <span class="ml-1">{{ cache()->get('todayIncome') }}</span>
            </li>
            <li class="flex items-center mt-1">
                <i class="fa fa-book mr-2" aria-hidden="true"></i>
                Yesterday income: <span class="ml-1">{{ cache()->get('yesterdayIncome') }}</span>
            </li>
            <li class="flex items-center mt-1">
                <i class="fa fa-book mr-2" aria-hidden="true"></i>
                Cash turnover: <span class="ml-1">{{ cache()->get('cashTurnover') }}</span>
            </li>
            <li class="flex items-center mt-4">
                <i class="fa fa-cogs mr-1" aria-hidden="true"></i>
                Operations: <span class="ml-1">{{ cache()->get('countAllRowsInDb') }}</span>
            </li>
            <li class="flex items-center mt-1">
                <i class="fa fa-book mr-2" aria-hidden="true"></i>
                System logs: <span class="ml-1">{{ cache()->get('countSystemLogs') }}</span>
            </li>
        </ul>
    </nav>
</aside>

<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black opacity-50 z-40 md:hidden"></div>
