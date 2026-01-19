<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $positions = Position::all();
        return view('employees.index', compact('employees', 'positions'));
    }

    public function create()
    {
        $positions = Position::all();
        return view('employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'dni' => 'required|integer|digits:8|unique:employees,dni',
            'position' => 'required',
            'base_salary' => 'required|numeric',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee created.');
    }

    public function show(Employee $employee)
    {
        $positions = Position::all();
        return view('employees.show', compact('employee', 'positions'));
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'dni' => 'required',
            'position' => 'required',
            'base_salary' => 'required|numeric',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }
}
