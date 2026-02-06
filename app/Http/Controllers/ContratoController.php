<?
namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\TipoContrato;
use App\Models\JornadaLaboral;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function index()
    {
        $contratos = Contrato::with(['empleado', 'cargo'])->orderBy('id', 'desc')->paginate(10);
        return view('contratos.index', compact('contratos'));
    }

    public function create()
    {
        $empleados = Empleado::where('estado', 'Activo')->get();
        $cargos = Cargo::all();
        $tipos = TipoContrato::all();
        $jornadas = JornadaLaboral::all();
        return view('contratos.create', compact('empleados', 'cargos', 'tipos', 'jornadas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'cargo_id' => 'required|exists:cargos,id',
            'tipo_contrato_id' => 'required|exists:tipos_contrato,id',
            'jornada_id' => 'required|exists:jornadas_laborales,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'salario_pactado' => 'required|numeric|min:0',
            'estado' => 'required|string'
        ]);

        // Si el nuevo contrato es 'Vigente', ponemos los anteriores del empleado como 'Vencido'
        if ($data['estado'] === 'Vigente') {
            Contrato::where('empleado_id', $data['empleado_id'])->update(['estado' => 'Vencido']);
        }

        Contrato::create($data);
        return redirect()->route('contratos.index')->with('success', 'Contrato creado exitosamente.');
    }

    public function edit(Contrato $contrato)
    {
        $empleados = Empleado::all();
        $cargos = Cargo::all();
        $tipos = TipoContrato::all();
        $jornadas = JornadaLaboral::all();
        return view('contratos.edit', compact('contrato', 'empleados', 'cargos', 'tipos', 'jornadas'));
    }

    public function update(Request $request, Contrato $contrato)
    {
        $data = $request->validate([
            'cargo_id' => 'required|exists:cargos,id',
            'tipo_contrato_id' => 'required|exists:tipos_contrato,id',
            'jornada_id' => 'required|exists:jornadas_laborales,id',
            'salario_pactado' => 'required|numeric|min:0',
            'estado' => 'required|string',
            'fecha_fin' => 'nullable|date'
        ]);

        $contrato->update($data);
        return redirect()->route('contratos.index')->with('success', 'Contrato actualizado.');
    }

    public function destroy(Contrato $contrato)
    {
        $contrato->delete();
        return redirect()->route('contratos.index')->with('success', 'Contrato eliminado.');
    }
}
