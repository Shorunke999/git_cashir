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
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pay') }}">
                        @csrf
                        <div class="" style="margin-bottom:40px;">
                            <div class="col-md-8 col-md-offset-2">
                                <p>
                                    <div>
                                        Make payment to Cashir (NGN)
                                    </div>
                                </p>
                                <input type="text" name="amount" value="800" class="mt-4">

                                <!-- Payment Provider Selection Dropdown -->
                                <div class="mt-4" id="payment_section">
                                    <label for="paymentProvider" class="block font-medium text-gray-700">Select Payment Provider</label>
                                    @if ($data_count > 1)
                                        <select name="provider" id="paymentProvider" class="mt-1 block  rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="paystack">Paystack</option>
                                            <option value="flutterwave">Flutter Wave</option>
                                        </select>
                                    @else

                                    @endif
                                        <!-- Add more options as needed -->

                                </div>
                                <p  class="mt-4">
                                    <button class="btn btn-success btn-lg btn-block bg-blue-600" type="submit" value="Pay Now!">
                                        <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                                    </button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

