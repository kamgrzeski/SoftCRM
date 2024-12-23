<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Password reset'])
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
                    <p class="text-xl">Settings</p>
                </div>
            </div>

            <div class="w-full bg-white shadow-md rounded-lg">
                <div class="p-6">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                @include('layouts.components.forms.input', [
                                    'name' => 'Pagination size',
                                    'inputId' => 'pagination_size',
                                    'inputName' => 'pagination_size',
                                    'inputType' => 'text',
                                    'inputValue' => $settings->where('key', 'pagination_size')->first()->value,
                                    'inputRequired' => true
                                ])

                                @include('layouts.components.forms.input', [
                                    'name' => 'Priority size',
                                    'inputId' => 'priority_size',
                                    'inputName' => 'priority_size',
                                    'inputType' => 'text',
                                    'inputValue' => $settings->where('key', 'priority_size')->first()->value,
                                    'inputRequired' => true
                                ])

                                <div class="mb-4">
                                    <label for="client_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Loading circle</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                            <span class="text-gray-500"><i class="fa fa-pencil"></i></span>
                                        </span>
                                        <select id="loading_circle" name="loading_circle" required
                                                class="rounded-none rounded-e-lg border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="" disabled selected>Select an option</option>
                                            <option value="1" {{ $settings->where('key', 'loading_circle')->first()->value == 1 ? 'selected' : '' }}>Show</option>
                                            <option value="0" {{ $settings->where('key', 'loading_circle')->first()->value == 0 ? 'selected' : '' }}>Don't show</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <label for="client_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Currency</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                            <span class="text-gray-500"><i class="fa fa-pencil"></i></span>
                                        </span>
                                        <select id="currency" name="currency" required
                                                class="rounded-none rounded-e-lg border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="PLN" {{ $settings->where('key', 'currency')->first()->value == 'PLN' ? 'selected' : '' }}>PLN</option>
                                            <option value="EUR" {{ $settings->where('key', 'currency')->first()->value == 'EUR' ? 'selected' : '' }}>EUR</option>
                                            <option value="USD" {{ $settings->where('key', 'currency')->first()->value == 'USD' ? 'selected' : '' }}>USD</option>
                                        </select>
                                    </div>
                                </div>

                                @include('layouts.components.forms.input', [
                                    'name' => 'Tax',
                                    'inputId' => 'invoice_tax',
                                    'inputName' => 'invoice_tax',
                                    'inputType' => 'text',
                                    'inputValue' => $settings->where('key', 'invoice_tax')->first()->value,
                                    'inputRequired' => true
                                ])
                            </div>
                        </div>

                        <div class="flex justify-end border-t border-gray-200">
                            <button type="submit" class="bg-blue-500 mt-3 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Update settings</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>

        @include('layouts.footer')
    </div>
</div>

</body>
</html>
