<header class="shadow-md flex items-center justify-between p-4 bg-gray-800 text-white transform transition-transform duration-200 ease-in-out z-50 md:static md:translate-x-0">
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
    <div class="relative" x-data="{ dropdownOpen: false }">
        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center focus:outline-none">
            <img src="{{ asset('./images/avatar.png') }}" alt="Avatar" class="w-8 h-8 rounded-full mr-3">

            <span class="ml-2 hidden sm:block">Welcome {{{ auth()->user()->name }}}</span>

            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
            <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Settings</a>
            <a href="{{ route('password.reset') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Password reset</a>
            <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</a>
        </div>
    </div>
</header>
