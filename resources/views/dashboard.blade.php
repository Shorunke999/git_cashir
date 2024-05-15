<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('msg'))
                    <div>
                        session('msg')
                    </div>
                @session

                @endif
                <div class="p-6 text-gray-900"><h1>Active Payment system platforms</h1>
                    <div class="flex items-center space-x-4 mt-4">
                        <a href="{{route('change_payment',['status' => 'BothPlatforms'])}}">
                            <button id="bothBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full focus:outline-none">Activate both payment platform</button>
                        </a>
                        <a href="{{route('change_payment', ['status' => 'Flutterwave'])}}">
                            <button id="oneBtn" class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded-full focus:outline-none">Flutter wave only</button>
                        </a>
                        <a href="{{route('change_payment',['status' => 'Paystack'])}}">
                            <button id="zeroBtn" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-full focus:outline-none">Paystack only</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
