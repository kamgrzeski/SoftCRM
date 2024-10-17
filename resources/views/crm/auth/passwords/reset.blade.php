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
                    <p class="text-xl">Password reset</p>
                </div>
            </div>

            <div class="w-full bg-white shadow-md rounded-lg">
                <div class="p-6">
                    <form action="{{ route('password.reset.process') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                @include('layouts.components.forms.input', [
                                    'name' => 'Old password',
                                    'inputId' => 'old-password',
                                    'inputName' => 'old_password',
                                    'inputType' => 'password',
                                    'inputRequired' => true
                                ])
                            </div>

                            <div>
                                @include('layouts.components.forms.input', [
                                    'name' => 'New password',
                                    'inputId' => 'new-password',
                                    'inputName' => 'new_password',
                                    'inputType' => 'password',
                                    'inputRequired' => true
                                ])

                                @include('layouts.components.forms.input', [
                                    'name' => 'Repeat new password',
                                    'inputId' => 'confirm-password',
                                    'inputName' => 'confirm_password',
                                    'inputType' => 'password',
                                    'inputRequired' => true
                                ])
                            </div>
                        </div>

                        <div class="flex justify-end border-t border-gray-200">
                            <button type="submit" class="bg-blue-500 mt-3 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add client</button>
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
