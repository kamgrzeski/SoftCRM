<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Finances lists'])
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
                    <p class="text-xl">Finances lists</p>
                    <a href="{{ route('finances.create.form') }}" class="text-blue-500 hover:text-blue-700">
                        <button class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                            <i class="fas fa-plus"></i> Add new finance
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
                            <th class="px-4 py-2 text-center border border-gray-300">Category</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Type</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Gross</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Net</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Vat</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Assigned companies</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Date</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Status</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($finances as $key => $finance)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $key+1 }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $finance->name }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $finance->category }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $finance->type }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $finance->gross }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $finance->net }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $finance->vat }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">
                                    <a href="{{ route('clients.view', $finance->company->id) }}">{{ $finance->company->name }}</a>
                                </td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $finance->date }}</td>

                                <td class="px-4 py-2 text-center border border-gray-300">
                                    <form method="POST" action="{{ route('finances.set.active', $finance) }}">
                                        @csrf
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer"  onchange="this.form.submit()" @if($finance->is_active) checked @endif>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </form>
                                </td>
                                <td class="px-4 py-2 text-center border border-gray-300">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ route('finances.view', $finance) }}" class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                            More info
                                        </a>

                                        <a href="{{ route('finances.update.form', $finance) }}" class="bg-yellow-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('finances.delete', $finance) }}" class="inline">
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
                        {!! $finances->render() !!}
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>
</body>
</html>
