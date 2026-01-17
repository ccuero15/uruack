<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employees
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-4">Create Employee</a>
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Base Salary</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->base_salary }}</td>
                                    <td>{{ $employee->active ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display:inline">
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
