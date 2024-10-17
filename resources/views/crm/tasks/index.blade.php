<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Tasks lists'])
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
                    <p class="text-xl">Tasks lists</p>
                    <a href="{{ route('tasks.create.form') }}" class="text-blue-500 hover:text-blue-700">
                        <button class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                            <i class="fas fa-plus"></i> Add new task
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
                            <th class="px-4 py-2 text-center border border-gray-300">Assigned employee</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Duration</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Is completed?</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Status</th>
                            <th class="px-4 py-2 text-center border border-gray-300">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $key => $task)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $key+1 }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $task->name }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">
                                    <a href="{{ route('employees.view',$task->employee->id) }}">{{ $task->employee->full_name }}</a>
                                </td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $task->duration . ' days' }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">{{ $task->completed ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-2 text-center border border-gray-300">
                                    <form method="POST" action="{{ route('tasks.set.active', $task) }}">
                                        @csrf
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer"  onchange="this.form.submit()" @if($task->is_active) checked @endif>
                                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        </label>
                                    </form>
                                </td>
                                <td class="px-4 py-2 text-center border border-gray-300">
                                    <div class="flex justify-center items-center space-x-2">
                                        <a href="{{ route('tasks.view', $task) }}" class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                            More info
                                        </a>

                                        <a href="{{ route('tasks.update.form', $task) }}" class="bg-yellow-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('tasks.complete', $task) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                                Mark as @if($task->completed) uncompleted @else completed @endif
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('tasks.delete', $task) }}" class="inline">
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
                        {!! $tasks->render() !!}
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>
</body>
</html>
