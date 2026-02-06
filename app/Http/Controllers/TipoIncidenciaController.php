<?php

namespace App\Http\Controllers;

use App\Models\TipoIncidencia;
use Illuminate\Http\Request;

class TipoIncidenciaController extends Controller
{
    public function index()
    {
        $tipos = TipoIncidencia::all();
        return view('incidencias.tipos.index', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50',
            'afecta_pago' => 'required|boolean',
        ]);
        TipoIncidencia::create($data);
        return redirect()->back()->with('success', 'Tipo de incidencia creado.');
    }
}
