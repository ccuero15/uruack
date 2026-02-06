<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use Illuminate\Http\Request;

class BeneficioController extends Controller
{
public function index() {
    return redirect()->route('deducciones.index');
}

    public function store(Request $request) {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);
        Beneficio::create($data);
        return redirect()->back()->with('success', 'Deducción creada.');
    }

    public function update(Request $request, Beneficio $deduccion) {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);
        $deduccion->update($data);
        return redirect()->back()->with('success', 'Deducción actualizada.');
    }

    public function destroy(Beneficio $deduccion) {
        $deduccion->delete();
        return redirect()->back()->with('success', 'Deducción eliminada.');
    }
}
