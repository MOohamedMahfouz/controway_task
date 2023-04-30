
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
                                                Products:
                                            </td>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                <select name="mappings[]" class="form-select dark:bg-gray-700 dark:text-gray-300">
                                                    <option value="{{$map[0]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[0]}}</option>
                                                    <option value="{{$map[1]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[1]}}</option>
                                                    <option value="{{$map[2]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[2]}}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                Type:
                                            </td>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                <select name="mappings[]" class="form-select dark:bg-gray-700 dark:text-gray-300">
                                                    <option value="{{$map[1]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[1]}}</option>
                                                    <option value="{{$map[0]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[0]}}</option>
                                                    <option value="{{$map[2]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[2]}}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                Quantity:
                                            </td>
                                            <td class="px-4 py-2 border dark:border-gray-700">
                                                <select name="mappings[]" class="form-select dark:bg-gray-700 dark:text-gray-300">
                                                    <option value="{{$map[2]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[2]}}</option>
                                                    <option value="{{$map[0]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[0]}}</option>
                                                    <option value="{{$map[1]}}" class="dark:bg-gray-800 dark:text-gray-300">{{$map[1]}}</option>
                                                </select>
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
