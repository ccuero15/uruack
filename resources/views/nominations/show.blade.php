<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nomination: {{ $nomination->period }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Status: {{ $nomination->status }}</p>
                    @if($nomination->status == 'pending')
                        <form action="{{ route('nominations.process', $nomination) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary mb-4">Process Nomination</button>
                        </form>
                    @endif
                    @if($nomination->status == 'approved')
                        <h2 class="text-lg font-bold mb-2">Details</h2>
                        <table class="table w-full">
                            @foreach($nomination->details->groupBy('employee_id') as $employee_id => $details)
                                @php $employee = App\Models\Employee::find($employee_id); @endphp
                                <tr><th colspan="2" class="bg-gray-200">Employee: {{ $employee->name }}</th></tr>
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{ $detail->concept->name }}</td>
                                        <td>{{ $detail->amount }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    @endif
                    @if($nomination->incidents->count() > 0)
                        <h2 class="text-lg font-bold mb-2">Incidents</h2>
                        <ul>
                            @foreach($nomination->incidents as $incident)
                                <li>{{ $incident->description }} (Employee: {{ $incident->employee->name }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
