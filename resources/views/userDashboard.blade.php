<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex justify-center items-center space-x-3">
            </div>
        </h2>
        <!--
            {{ __('Dashboard') }}  {{ __("You're logged in!") }}
        -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-center items-center">
                    <div class="w-full max-w-md">
                        @if($msg)
                            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                                {{$msg }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('pay') }}" class="">
                            @csrf
                            <div class="">
                                <div>
                                    Make payment to Cashir (NGN)
                                </div>
                                <input type="text" name="amount" value="800" class="mt-4 block w-full px-3 py-2 border rounded-md">
                            </div>

                            <!-- Payment Provider Selection Dropdown -->
                            <div class="mb-6">
                                <label for="paymentProvider" class="block text-gray-700 font-medium mb-2">Select Payment Provider</label>
                                @if ($data_count > 1)
                                    <select name="provider" id="paymentProvider" class="block w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="monny">Monnify</option>
                                        <option value="paystack">Paystack</option>
                                    </select>
                                @else
                                    @foreach ($data as $data)
                                        @if ($data->platform_name === 'monny')
                                            <select name="provider" id="paymentProvider" class="block w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="monny">Monnify</option>
                                            </select>
                                        @else
                                            <select name="provider" id="paymentProvider" class="block w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="paystack">Paystack</option>
                                            </select>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            <button class="w-full bg-blue-600 text-white font-bold py-2 rounded" type="submit">
                                <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
