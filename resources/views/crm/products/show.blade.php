<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Show product'])
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
                    <p class="text-xl">Product details: {{ $product->name }}</p>
                    <a href="{{ url()->previous() }}">
                        <form method="POST" action="{{ route('products.delete', $product) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                Delete this product
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
                    </ul>

                    <div class="py-6">
                        <!-- Basic information tab -->
                        <div x-show="tab === 'home'">
                            <table class="w-full text-left border border-gray-300">
                                <tbody class="text-right">
                                <tr class="border-b">
                                    <th class="px-4 py-2">Name</th>
                                    <td class="px-4 py-2">{{ $product->name }}</td>
                                </tr>

                                <tr class="border-b">
                                    <th class="px-4 py-2">Category</th>
                                    <td class="px-4 py-2">{{ $product->category }}</td>
                                </tr>

                                <tr class="border-b">
                                    <th class="px-4 py-2">Count</th>
                                    <td class="px-4 py-2">{{ $product->count }}</td>
                                </tr>

                                <tr class="border-b">
                                    <th class="px-4 py-2">Price</th>
                                    <td class="px-4 py-2">
                                        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-1 px-4 border border-gray-400 rounded shadow">
                                            {{ \Cknow\Money\Money::{\App\Queries\SettingsQueries::getSettingValue('currency')}($product->price) }}
                                        </button>
                                    </td>

                                <tr>
                                    <th>Status</th>
                                    <td class="px-4 py-2">{{ $product->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>

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
