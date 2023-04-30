<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2 class="pt-10">
            @if (session()->has('success'))
                <div class="bg-green-500 text-white text-xl font-bold px-6 py-4 rounded-lg mb-6">
                    {{ session()->get('success') }}
                </div>
            @elseif (session()->has('error'))
                <div class="bg-red-500 text-white text-xl font-bold px-6 py-4 rounded-lg mb-6">
                    {{ session()->get('error') }}
                </div>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="/import-products" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col space-y-2">
                            <label for="file" class="text-white text-gray-700 font-medium">Select Excel file:</label>
                            <input type="file" name="file" id="file" class="w-96 py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
                        </div>
                        <button type="submit" class="mt-4 px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                            Import Products +
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
