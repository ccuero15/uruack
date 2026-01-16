<?php

namespace App\Http\Controllers;

use App\Models\Nomination;
use App\Models\Employee;
use App\Models\Concept;
use App\Models\NominationDetail;
use App\Models\Incident;
use Illuminate\Http\Request;

class NominationController extends Controller
{
    public function index()
    {
        $nominations = Nomination::all();
        return view('nominations.index', compact('nominations'));
    }

    public function create()
    {
        return view('nominations.create');
    }

    public function store(Request $request)
    {
        $request->validate(['period' => 'required|unique:nominations']);
        $nomination = Nomination::create(['period' => $request->period]);
        return redirect()->route('nominations.show', $nomination)->with('success', 'Nomination created.');
    }

    public function show(Nomination $nomination)
    {
        return view('nominations.show', compact('nomination'));
    }

    public function edit(Nomination $nomination)
    {
        return view('nominations.edit', compact('nomination'));
    }

    public function update(Request $request, Nomination $nomination)
    {
        $request->validate(['period' => 'required|unique:nominations,period,' . $nomination->id]);
        $nomination->update(['period' => $request->period]);
        return redirect()->route('nominations.index')->with('success', 'Nomination updated.');
    }

    public function destroy(Nomination $nomination)
    {
        $nomination->delete();
        return redirect()->route('nominations.index')->with('success', 'Nomination deleted.');
    }

    // Step 1-3: Process nomination (consult active employees, loop, obtain concepts)
    public function process(Nomination $nomination)
    {
        if ($nomination->status !== 'pending') {
            return redirect()->back()->with('error', 'Nomination already processed.');
        }

        $employees = Employee::where('active', true)->get();
        $concepts = Concept::all(); // Assume all concepts apply to all employees for simplicity; customize if needed

        $preliminary = [];
        $incidents = [];

        foreach ($employees as $employee) {
            $assignments = 0;
            $deductions = 0;

            foreach ($concepts as $concept) {
                $amount = $concept->is_percentage ? ($employee->base_salary * $concept->value / 100) : $concept->value;

                if ($concept->type === 'assignment') {
                    $assignments += $amount;
                } else {
                    $deductions += $amount;
                }

                // Temp save for preliminary
                $preliminary[$employee->id]['details'][] = [
                    'concept' => $concept,
                    'amount' => $amount,
                ];
            }

            $net_pay = $employee->base_salary + $assignments - $deductions;

            // Error detection (e.g., negative pay)
            if ($net_pay < 0) {
                $incidents[] = [
                    'employee' => $employee,
                    'description' => 'Negative net pay: ' . $net_pay,
                ];
            }

            $preliminary[$employee->id]['net_pay'] = $net_pay;
            $preliminary[$employee->id]['employee'] = $employee;
        }

        // Show preliminary summary
        return view('nominations.process', compact('nomination', 'preliminary', 'incidents'));
    }

    // Step 10-12: Approve (register details, update status, confirm)
    public function approve(Request $request, Nomination $nomination)
    {
        // Assume from process view, we post to approve
        // In real, validate no incidents or resolved

        $employees = Employee::where('active', true)->get();
        $concepts = Concept::all();

        foreach ($employees as $employee) {
            foreach ($concepts as $concept) {
                $amount = $concept->is_percentage ? ($employee->base_salary * $concept->value / 100) : $concept->value;

                NominationDetail::create([
                    'nomination_id' => $nomination->id,
                    'employee_id' => $employee->id,
                    'concept_id' => $concept->id,
                    'amount' => $concept->type === 'assignment' ? $amount : -$amount, // Store signed
                ]);
            }
        }

        $nomination->update(['status' => 'approved']);

        // Step 13: Generate list (for now, redirect to show with details)
        return redirect()->route('nominations.show', $nomination)->with('success', 'Nomination approved and details saved.');
    }

    // Step 14-15: Reject (record incidents, back to modify)
    public function reject(Request $request, Nomination $nomination)
    {
        $request->validate(['incidents' => 'required|array']);

        foreach ($request->incidents as $employee_id => $description) {
            Incident::create([
                'nomination_id' => $nomination->id,
                'employee_id' => $employee_id,
                'description' => $description,
            ]);
        }

        $nomination->update(['status' => 'rejected']);

        return redirect()->route('nominations.show', $nomination)->with('error', 'Nomination rejected. Correct data and retry.');
    }
}
