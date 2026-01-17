<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Process Nomination: {{ $nomination->period }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-bold mb-2">Preliminary Summary</h2>
                    <table class="table w-full">
                        @foreach($preliminary as $data)
                            <tr><th colspan="2" class="bg-gray-200">Employee: {{ $data['employee']->name }} - Net Pay: {{ $data['net_pay'] }}</th></tr>
                            @foreach($data['details'] as $detail)
                                <tr>
                                    <td>{{ $detail['concept']->name }} ({{ $detail['concept']->type }})</td>
                                    <td>{{ $detail['amount'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>

                    @if(count($incidents) > 0)
                        <h2 class="text-lg font-bold mb-2">Incidents (Errors Detected)</h2>
                        <ul>
                            @foreach($incidents as $incident)
                                <li>{{ $incident['description'] }} (Employee: {{ $incident['employee']->name }})</li>
                            @endforeach
                        </ul>
                    @endif

                    <form action="{{ route('nominations.approve', $nomination) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-success mr-2">Approve and Save</button>
                    </form>

                    <form action="{{ route('nominations.reject', $nomination) }}" method="POST" class="mt-4 inline">
                        @csrf
                        <!-- For simplicity, hidden inputs for incidents; in production, make editable -->
                        @foreach($incidents as $incident)
                            <input type="hidden" name="incidents[{{ $incident['employee']->id }}]" value="{{ $incident['description'] }}">
                        @endforeach
                        <button type="submit" class="btn btn-danger">Reject and Correct</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
