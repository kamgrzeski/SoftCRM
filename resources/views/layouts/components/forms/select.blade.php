<div class="mb-4">
    <label for="full-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $name }}</label>
    <div class="flex">
        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
            <span class="text-gray-500"><i class="fa fa-pencil"></i></span>
        </span>
        <select id="{{ $inputId }}" name="{{ $inputName }}"
                @if(isset($inputRequired)) required @endif
                @if(isset($inputDisabled)) disabled @endif
                class="rounded-none rounded-e-lg border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="" disabled selected>Select an option</option>
            @foreach($options as $option)
                <option value="{{ $option->id }}" @if(isset($inputValue) && $inputValue == $option->id) selected @endif>{{ $option->name }}</option>
            @endforeach
        </select>
    </div>
</div>
