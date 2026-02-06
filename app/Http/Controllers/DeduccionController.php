<?php

namespace App\Http\Controllers;

use App\Models\Deduccion;
use Illuminate\Http\Request;

class DeduccionController extends Controller
{
    public function index()
    {
        $deducciones = \App\Models\Deduccion::all();
        $beneficios = \App\Models\Beneficio::all(); // Cargamos ambos para la vista unificada
        return view('configuracion.conceptos', compact('deducciones', 'beneficios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);
        Deduccion::create($data);
        return redirect()->back()->with('success', 'Deducción creada.');
    }

    public function update(Request $request, Deduccion $deduccion)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);
        $deduccion->update($data);
        return redirect()->back()->with('success', 'Deducción actualizada.');
    }

    public function destroy(Deduccion $deduccion)
    {
        $deduccion->delete();
        return redirect()->back()->with('success', 'Deducción eliminada.');
    }
}
