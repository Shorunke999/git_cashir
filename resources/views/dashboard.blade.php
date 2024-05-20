<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('msg'))
            <div>
                {{session('msg')}}
            </div>
        @endif
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between">
                      <div class="flex items-center space-x-4 mt-4">
                        <a href="{{route('change_payment',['status' => 'BothPlatforms'])}}">
                            <button  class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-full focus:outline-none">Activate both payment platform</button>
                        </a>
                        <a href="{{route('change_payment', ['status' => 'Monny'])}}">
                            <button  class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded-full
                             focus:outline-none">Monnify only</button>
                        </a>

                        <a href="{{route('change_payment',['status' => 'Paystack'])}}">
                            <button  class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-full focus:outline-none">Paystack only</button>
                        </a>
                    </div>
                    <div class="mt-4 ">
                        <a href="{{route('userDashboard')}}" class="hover:bg-gray-300 rounded-full px-10 ">Make Payment</a>
                    </div>
                </div>
                <div class="mt-10 ">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Platform</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delete Record</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($records as $record)
                            <tr class="text-center">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->user_email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->reference }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->Payment_platform }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->fees }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->updated_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ url('/deleteRecord', $record->id) }}" class="text-red-600 hover:text-red-900">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>


        </div>
    </div>
</x-app-layout>
