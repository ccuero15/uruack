<?

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::orderBy('titulo')->paginate(10);
        return view('cargos.index', compact('cargos'));
    }

    public function create()
    {
        return view('cargos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'salario_referencial' => 'nullable|numeric|min:0',
        ]);

        Cargo::create($data);
        return redirect()->route('cargos.index')->with('success', 'Cargo creado exitosamente.');
    }

    public function edit(Cargo $cargo)
    {
        return view('cargos.edit', compact('cargo'));
    }

    public function update(Request $request, Cargo $cargo)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'salario_referencial' => 'nullable|numeric|min:0',
        ]);

        $cargo->update($data);
        return redirect()->route('cargos.index')->with('success', 'Cargo actualizado.');
    }

    public function destroy(Cargo $cargo)
    {
        // Validación: No eliminar si hay contratos asociados
        if ($cargo->contratos()->count() > 0) {
            return redirect()->route('cargos.index')->with('error', 'No se puede eliminar un cargo que tiene contratos asociados.');
        }

        $cargo->delete();
        return redirect()->route('cargos.index')->with('success', 'Cargo eliminado.');
    }
}
