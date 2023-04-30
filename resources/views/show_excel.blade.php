
@props(['map'])
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
                    <form action="/import-products-mapping" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="overflow-x-auto">
                                <table class="table-auto border-collapse w-full dark:border-gray-700 dark:text-gray-300">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 border dark:border-gray-700">
                                                Database Field Names
                                            </th>
                                            <th class="px-4 py-2 border dark:border-gray-700">
                                                Excel Column Headers
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                <select name="mappings['name']" class="form-select dark:bg-gray-700 dark:text-gray-300">
                                                    <option value="name" class="dark:bg-gray-800 dark:text-gray-300">Products</option>
                                                    <option value="type" class="dark:bg-gray-800 dark:text-gray-300">Type</option>
                                                    <option value="qty" class="dark:bg-gray-800 dark:text-gray-300">Quantity</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                {{$map[0]}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                <select name="mappings['type']" class="form-select dark:bg-gray-700 dark:text-gray-300">
                                                    <option value="type" class="dark:bg-gray-800 dark:text-gray-300">Type</option>
                                                    <option value="name" class="dark:bg-gray-800 dark:text-gray-300">Products</option>
                                                    <option value="qty" class="dark:bg-gray-800 dark:text-gray-300">Quantity</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                {{$map[1]}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                <select name="mappings['qty']" class="form-select dark:bg-gray-700 dark:text-gray-300">
                                                    <option value="qty" name="qty" class="dark:bg-gray-800 dark:text-gray-300">Quantity</option>
                                                    <option value="name" class="dark:bg-gray-800 dark:text-gray-300">Products</option>
                                                    <option value="type" class="dark:bg-gray-800 dark:text-gray-300">Type</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                {{$map[2]}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <button type="submit" class="mt-4 px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                            Import
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
