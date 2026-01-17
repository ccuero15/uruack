<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Concepts
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('concepts.create') }}" class="btn btn-primary mb-4">Create Concept</a>
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Percentage?</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($concepts as $concept)
                                <tr>
                                    <td>{{ $concept->name }}</td>
                                    <td>{{ $concept->type }}</td>
                                    <td>{{ $concept->value }}</td>
                                    <td>{{ $concept->is_percentage ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('concepts.edit', $concept) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('concepts.destroy', $concept) }}" method="POST" style="display:inline">
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
