<?php

namespace App\Http\Controllers;

use App\Models\Deduccion;
use App\Models\Beneficio;
use Illuminate\Http\Request;

class DeduccionController extends Controller
{
    public function index()
    {
        $deducciones = Deduccion::all();
        $beneficios = Beneficio::all();
        return view('configuracion.conceptos', compact('deducciones', 'beneficios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0|max:9999999999.99',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);

        try {
            Deduccion::create($data);
            return redirect()->back()->with('success', 'Deducción creada.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al crear la deducción: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Deduccion $deduccion)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0|max:9999999999.99',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);

        try {
            $deduccion->update($data);
            return redirect()->back()->with('success', 'Deducción actualizada.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la deducción: ' . $e->getMessage());
        }
    }

    public function destroy(Deduccion $deduccion)
    {
        try {
            $deduccion->delete();
            return redirect()->back()->with('success', 'Deducción eliminada.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la deducción: ' . $e->getMessage());
        }
    }
}
