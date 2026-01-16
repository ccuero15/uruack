<?php

namespace App\Http\Controllers;

use App\Models\Concept;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    public function index()
    {
        $concepts = Concept::all();
        return view('concepts.index', compact('concepts'));
    }

    public function create()
    {
        return view('concepts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:assignment,deduction',
            'value' => 'required|numeric',
            'is_percentage' => 'boolean',
        ]);

        Concept::create($request->all());
        return redirect()->route('concepts.index')->with('success', 'Concept created.');
    }

    public function show(Concept $concept)
    {
        return view('concepts.show', compact('concept'));
    }

    public function edit(Concept $concept)
    {
        return view('concepts.edit', compact('concept'));
    }

    public function update(Request $request, Concept $concept)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:assignment,deduction',
            'value' => 'required|numeric',
            'is_percentage' => 'boolean',
        ]);

        $concept->update($request->all());
        return redirect()->route('concepts.index')->with('success', 'Concept updated.');
    }

    public function destroy(Concept $concept)
    {
        $concept->delete();
        return redirect()->route('concepts.index')->with('success', 'Concept deleted.');
    }
}
