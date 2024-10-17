<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Show client'])
<body class="bg-gray-100">

<div class="flex h-screen" x-data="{ sidebarOpen: false }">
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col">
        @include('layouts.header')

        <main class="flex-1 p-6 overflow-y-auto">
            <div>
                @include('layouts.flash-messages')
            </div>

            <div class="w-full bg-white shadow-md rounded-lg mb-3">
                <div class="p-6 flex justify-between items-center">
                    <p class="text-xl">Client details: {{ $client->full_name }}</p>
                    <a href="{{ url()->previous() }}">
                        <form method="POST" action="{{ route('clients.delete', $client) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                Delete this client
                            </button>
                        </form>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div x-data="{ tab: 'home' }">
                    <ul class="flex border-b">
                        <li class="-mb-px mr-1">
                            <a href="#" @click.prevent="tab = 'home'" :class="{ 'border-grey-500 text-grey-500 border-t border-r border-l rounded-t': tab === 'home' }" class="bg-white inline-block py-2 px-4 text-grey-700">
                                Basic information
                            </a>
                        </li>
                        <li class="mr-1">
                            <a href="#" @click.prevent="tab = 'companies'" :class="{ 'border-grey-500 text-grey-500 border-t border-r border-l rounded-t': tab === 'companies' }" class="bg-white inline-block py-2 px-4 text-grey-700">
                                Assigned companies
                                <span class="ml-2 bg-yellow-500 text-white rounded-full px-2 py-1 text-xs">{{ count($client->companies) }}</span>
                            </a>
                        </li>
                        <li class="mr-1">
                            <a href="#" @click.prevent="tab = 'employees'" :class="{ 'border-grey-500 text-grey-500 border-t border-r border-l rounded-t': tab === 'employees' }" class="bg-white inline-block py-2 px-4 text-grey-700">
                                Assigned employees
                                <span class="ml-2 bg-yellow-500 text-white rounded-full px-2 py-1 text-xs">{{ count($client->employees) }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="py-6">
                        <!-- Basic information tab -->
                        <div x-show="tab === 'home'">
                            <table class="w-full text-left border border-gray-300">
                                <tbody class="text-right">
                                <tr class="border-b">
                                    <th class="px-4 py-2">Full name</th>
                                    <td class="px-4 py-2">{{ $client->full_name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Phone</th>
                                    <td class="px-4 py-2">{{ $client->phone }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Email address</th>
                                    <td class="px-4 py-2">{{ $client->email }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Section</th>
                                    <td class="px-4 py-2">{{ $client->section }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Budget</th>
                                    <td class="px-4 py-2">
                                        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-1 px-4 border border-gray-400 rounded shadow">
                                            {{ $client->formattedBudget }}
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Status</th>
                                    <td class="px-4 py-2">{{ $client->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Companies tab -->
                        <div x-show="tab === 'companies'">
                            <h4 class="text-lg font-semibold mb-4">List of companies</h4>
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border">Name</th>
                                    <th class="px-4 py-2 border">Tax number</th>
                                    <th class="px-4 py-2 border">Phone</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($client->companies as $company)
                                    <tr>
                                        <td class="px-4 py-2 border text-center">{{ $company->name }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $company->tax_number }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $company->phone }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Employees tab -->
                        <div x-show="tab === 'employees'">
                            <h4 class="text-lg font-semibold mb-4">List of employees</h4>
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border">Full name</th>
                                    <th class="px-4 py-2 border">Phone</th>
                                    <th class="px-4 py-2 border">Email address</th>
                                    <th class="px-4 py-2 border">Job</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($client->employees as $employees)
                                    <tr>
                                        <td class="px-4 py-2 border text-center">{{ $employees->full_name }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $employees->phone }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $employees->email }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $employees->job }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>


</body>
</html>
