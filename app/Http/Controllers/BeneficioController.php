<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use Illuminate\Http\Request;

class BeneficioController extends Controller
{
    public function index()
    {
        return redirect()->route('deducciones.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0|max:9999999999.99',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);

        try {
            Beneficio::create($data);
            return redirect()->back()->with('success', 'Beneficio creado.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al crear el beneficio: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Beneficio $beneficio)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0|max:9999999999.99',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);

        try {
            $beneficio->update($data);
            return redirect()->back()->with('success', 'Beneficio actualizado.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el beneficio: ' . $e->getMessage());
        }
    }

    public function destroy(Beneficio $beneficio)
    {
        try {
            $beneficio->delete();
            return redirect()->back()->with('success', 'Beneficio eliminado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el beneficio: ' . $e->getMessage());
        }
    }
}
