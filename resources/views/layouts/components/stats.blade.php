<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <i class="fas fa-user-friends fa-2x"></i>
            <div class="ml-4">
                <h2 class="text-lg font-bold">Clients: {{ cache()->get('countClients') }} ({{ cache()->get('deactivatedClients') }})</h2>
                <p class="text-sm">{{ cache()->get('clientsInLatestMonth') }}% increase in 30 days.</p>
            </div>
        </div>
    </div>

    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <i class="fas fa-building fa-2x"></i>
            <div class="ml-4">
                <h2 class="text-lg font-bold">Companies: {{ cache()->get('countCompanies') }} ({{ cache()->get('deactivatedCompanies') }})</h2>
                <p class="text-sm">{{ cache()->get('companiesInLatestMonth') }}%% increase in 30 days.</p>
            </div>
        </div>
    </div>

    <div class="bg-red-500 text-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <i class="fas fa-users fa-2x"></i>
            <div class="ml-4">
                <h2 class="text-lg font-bold">Employees: {{ cache()->get('countFinances') }}({{ cache()->get('deactivatedEmployees') }})</h2>
                <p class="text-sm">{{ cache()->get('employeesInLatestMonth') }}% increase in 30 days.</p>
            </div>
        </div>
    </div>

    <div class="bg-orange-500 text-white p-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <i class="fas fa-paperclip fa-2x"></i>
            <div class="ml-4">
                <h2 class="text-lg font-bold">Deals: {{ cache()->get('countDeals') }} ({{ cache()->get('deactivatedDeals') }})</h2>
                <p class="text-sm">{{ cache()->get('dealsInLatestMonth') }}% increase in 30 days.</p>
            </div>
        </div>
    </div>
</div>
