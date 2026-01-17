<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nominations
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('nominations.create') }}" class="btn btn-primary mb-4">Create Nomination</a>
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nominations as $nomination)
                                <tr>
                                    <td>{{ $nomination->period }}</td>
                                    <td>{{ $nomination->status }}</td>
                                    <td>
                                        <a href="{{ route('nominations.show', $nomination) }}" class="btn btn-info">View</a>
                                        <a href="{{ route('nominations.edit', $nomination) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('nominations.destroy', $nomination) }}" method="POST" style="display:inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
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
