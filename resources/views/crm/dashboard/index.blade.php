<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Dashboard'])
<body class="bg-gray-100">

<div class="flex h-screen" x-data="{ sidebarOpen: false }">
    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col">
        @include('layouts.header')

        <main class="flex-1 p-6 overflow-y-auto">
            <div>
                @include('layouts.flash-messages')

                @include('layouts.components.stats')

                @include('crm.dashboard.components.charts')

                <div class="mt-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 bg-white border p-4 text-white">
                            <div class="text-black p-3 border">
                                Latest tasks <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10"> {{ cache()->get('countTasks') }}</span>
                                <span class="float-right">
                                    Completed: {{ cache()->get('completedTasks') }} | Uncompleted: {{ cache()->get('uncompletedTasks') }}
                                </span>
                            </div>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Duration
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created at
                                    </th>
                                    <th scope="col" class="px-6 py-3 float-right">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                @if(count($tasks) > 0)
                                    <tbody>
                                    @foreach ($tasks as $result)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $result['name'] }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $result['duration'] . ' days' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $result['created_at']->diffForHumans() }}
                                            </td>
                                            <td class="px-6 py-4 float-right">
                                                <a href="{{ route('tasks.view', $result['id']) }}" class="text-blue-500 hover:text-blue-700">
                                                    <button class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button"
                                                    >
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @else
                                    There is no tasks.
                                @endif
                            </table>

                            <div class="text-right text-black p-2 border">
                                <a href="{{ route('tasks.index') }}">More Tasks <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="flex-1 bg-white border p-4 text-white">
                            <div class="text-black p-3 border">
                                Latest add products <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10"> {{ cache()->get('countProducts') }}</span>
                            </div>
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Count
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 float-right">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                @if(count($products) > 0)
                                    <tbody>
                                    @foreach ($products as $result)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $result->name }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $result->count }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ Cknow\Money\Money::{$currency}($result->price) }}
                                            </td>
                                            <td class="px-6 py-4 float-right">
                                                <a href="{{ route('products.view', $result->id) }}" class="text-blue-500 hover:text-blue-700">
                                                    <button class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
                                                        <i class="fas fa-eye"></i> View
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @else
                                    There is no products.
                                @endif
                            </table>

                            <div class="text-right text-black p-2 border">
                                <a href="{{ route('tasks.index') }}">More Tasks <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
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
