<!DOCTYPE html>
<html lang="pl">
@include('layouts.head', ['title' => 'Login'])
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="w-full max-w-sm bg-white p-6 rounded-lg shadow-lg">
    @include('layouts.flash-messages')
    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">SoftCRM</h2>
    <form action="{{ route('login.process') }}" method="POST">
        {{ csrf_field() }}
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-6">
            <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
            <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Login</button>
        </div>
    </form>
</div>
</body>
</html>
