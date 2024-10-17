<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Company lists'])
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
                    <p class="text-xl">Company lists</p>
                    <a href="{{ route('companies.create.form') }}" class="text-blue-500 hover:text-blue-700">
                        <button class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                            <i class="fas fa-plus"></i> Add new company
                        </button>
                    </a>
                </div>
            </div>

            <div class="w-full bg-white shadow-md rounded-lg mb-3">
                <div class="p-3 flex justify-between items-center">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-center border border-gray-300">#</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Name</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Phone</th>
                            <th class="px-4 py-2 text-center border border-gray-300">City</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Country</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Employee size</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Tax number</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $key => $company)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $key+1 }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $company->name }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $company->phone }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $company->city }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $company->country }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $company->employees_size }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $company->tax_number }}</td>

                                <td class="px-4 py-2 text-center border border-gray-300">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ route('companies.view', $company) }}" class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                            More info
                                        </a>

                                        <a href="{{ route('companies.update.form', $company) }}" class="bg-yellow-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('companies.delete', $company) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="py-2 border-t px-4">
                    <div class="p-2">
                        {!! $companies->render() !!}
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>
</body>
</html>
