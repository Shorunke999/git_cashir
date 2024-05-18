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
                            <button  class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded-full focus:outline-none">Monny only</button>
                        </a>

                        <a href="{{route('change_payment',['status' => 'Paystack'])}}">
                            <button  class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-full focus:outline-none">Paystack only</button>
                        </a>
                    </div>
                    <div class="mt-4 ">
                        <a href="{{route('userDashboard')}}" class="hover:bg-gray-300 rounded-full px-10 ">Make Payment</a>
                    </div>
                </div>
                <div class="mt-6 ">
                    <table>
                        <tr>
                            <th class="px-9">Email</th>
                            <th class="px-9">Reference Number</th>
                            <th class="px-9">Amount</th>
                            <th class="px-9">Payment platform</th>
                            <th class="px-9">Fee</th>
                            <th class="px-9">Timespamp</th>
                            <th class="px-9">Delete Record</th>
                        </tr>
                        @foreach ($records  as $record )
                        <tr>
                            <td> $record->user_email</td>
                            <td> $record->reference</td>
                            <td> $record->amount</td>
                            <td> $record->Payment_platform</td>
                            <td> $record->fees</td>
                            <td> $record->updated_at</td>
                            <td>
                                <a href="{{url('/deleteRecord',$record->id)}}" class="bg-red-500">Delete</a>
                            </td>
                        </tr>

                        @endforeach
                    </table>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
