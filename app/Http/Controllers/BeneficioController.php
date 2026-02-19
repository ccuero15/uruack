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
        Beneficio::create($data);
        return redirect()->back()->with('success', 'Beneficio creado.');
    }

    public function update(Request $request, Beneficio $beneficio)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tasa' => 'required|numeric|min:0|max:9999999999.99',
            'tipo' => 'required|in:Fijo,Porcentaje',
        ]);
        $beneficio->update($data);
        return redirect()->back()->with('success', 'Beneficio actualizado.');
    }

    public function destroy(Beneficio $beneficio)
    {
        $beneficio->delete();
        return redirect()->back()->with('success', 'Beneficio eliminado.');
    }
}
