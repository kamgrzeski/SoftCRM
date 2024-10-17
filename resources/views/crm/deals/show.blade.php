<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Show deal'])
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
                    <p class="text-xl">Deal details: {{ $deal->name }}</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('deals-terms.create.form', $deal) }}" class="bg-blue-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                            Add deal term
                        </a>
                        <form method="POST" action="{{ route('deals.delete', $deal) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                Delete this deal
                            </button>
                        </form>
                    </div>
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
                        <li class="-mb-px mr-1">
                            <a href="#" @click.prevent="tab = 'company'" :class="{ 'border-grey-500 text-grey-500 border-t border-r border-l rounded-t': tab === 'company' }" class="bg-white inline-block py-2 px-4 text-grey-700">
                                Company
                            </a>
                        </li>
                        <li class="mr-1">
                            <a href="#" @click.prevent="tab = 'deal-terms'" :class="{ 'border-grey-500 text-grey-500 border-t border-r border-l rounded-t': tab === 'deal-terms' }" class="bg-white inline-block py-2 px-4 text-grey-700">
                                Stored deal terms
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
                                    <td class="px-4 py-2">{{ $deal->name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Start time</th>
                                    <td class="px-4 py-2">{{ $deal->start_time }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">End time</th>
                                    <td class="px-4 py-2">{{ $deal->end_time }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Date</th>
                                    <td class="px-4 py-2">{{ $deal->date }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Status</th>
                                    <td class="px-4 py-2">{{ $deal->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- company tab -->
                        <div x-show="tab === 'company'">
                            <table class="w-full text-left border border-gray-300">
                                <tbody class="text-right">
                                <tr class="border-b">
                                    <th class="px-4 py-2">Company name</th>
                                    <td class="px-4 py-2">{{ $deal->company->name }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Tax number</th>
                                    <td class="px-4 py-2">{{ $deal->company->tax_number }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Phone</th>
                                    <td class="px-4 py-2">{{ $deal->company->phone }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">City</th>
                                    <td class="px-4 py-2">{{ $deal->company->city }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Billing address</th>
                                    <td class="px-4 py-2">{{ $deal->company->billing_address }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Country</th>
                                    <td class="px-4 py-2">{{ $deal->company->country }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Postal code</th>
                                    <td class="px-4 py-2">{{ $deal->company->postal_code }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Employees size</th>
                                    <td class="px-4 py-2">{{ $deal->company->employees_size }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Fax</th>
                                    <td class="px-4 py-2">{{ $deal->company->fax }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Description</th>
                                    <td class="px-4 py-2">{{ $deal->company->description }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-4 py-2">Status</th>
                                    <td class="px-4 py-2">{{ $deal->company->is_active ? 'Active' : 'Deactivate' }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- deal terms tab -->
                        <div x-show="tab === 'deal-terms'">
                            <h4 class="text-lg font-semibold mb-4">Stored deal terms</h4>
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 border">ID</th>
                                    <th class="px-4 py-2 border">body</th>
                                    <th class="px-4 py-2 border">Created at</th>
                                    <th class="px-4 py-2 border">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deal->dealTerms as $key => $terms)
                                    <tr>
                                        <td class="px-4 py-2 border text-center">{{ $terms->id }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $terms->body }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $terms->created_at }}</td>
                                        <td class="px-4 py-2 text-center border border-gray-300">
                                            <div class="flex justify-center items-center space-x-2">
                                                <form method="POST" action="{{ route('deals.terms.generate-pdf', ['deal' => $deal, 'dealTerm' => $terms]) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150">
                                                        Generate PDF
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('deals.terms.delete', $terms) }}" class="inline">
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
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>


</body>
</html>
