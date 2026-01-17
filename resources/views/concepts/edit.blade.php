<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Concept
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('concepts.update', $concept) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group mb-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control w-full" value="{{ $concept->name }}" required>
                        </div>
                        <div class="form-group mb-4">
                            <label>Type</label>
                            <select name="type" class="form-control w-full" required>
                                <option value="assignment" {{ $concept->type == 'assignment' ? 'selected' : '' }}>Assignment (Bonus)</option>
                                <option value="deduction" {{ $concept->type == 'deduction' ? 'selected' : '' }}>Deduction</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label>Value</label>
                            <input type="number" name="value" class="form-control w-full" value="{{ $concept->value }}" required>
                        </div>
                        <div class="form-group mb-4">
                            <label>Is Percentage?</label>
                            <input type="checkbox" name="is_percentage" value="1" {{ $concept->is_percentage ? 'checked' : '' }}>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
