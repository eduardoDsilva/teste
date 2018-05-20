<?php
/**
 * Created by PhpStorm.
 * User: eduardo.dgi
 * Date: 14/05/2018
 * Time: 09:49
 */

namespace App\Http\Controllers\Admin\Disciplinas;

use App\Disciplina;
use App\Http\Controllers\Auditoria\AuditoriaController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDisciplinaController extends Controller
{

    private $disciplinas;
    private $auditoriaController;

    public function __construct(Disciplina $disciplina, AuditoriaController $auditoriaController)
    {
        $this->disciplinas = $disciplina;
        $this->auditoriaController = $auditoriaController;
    }

    public function index()
    {
        $disciplinas = Disciplina::all();
        return view('admin/disciplinas/home', compact('disciplinas'));
    }

    public function store(Request $request){
        $dataForm = $request->all();
        try{
            $disciplinas = Disciplina::create($dataForm);
            $this->auditoriaController->storeCreate($disciplinas, $disciplinas->id);

            return redirect()
                ->route("admin/disciplinas/home")
                ->with("success", "disciplina ".$disciplinas->name." adicionada com sucesso");
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function show(){
        try{
            $disciplinas = disciplina::all();
            return view("admin/disciplinas/busca/buscar", compact('disciplinas'));
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function edit($id){
        try{
            $disciplina = disciplina::find($id);
            return view("admin/disciplinas/editar/editar", compact('disciplina'));
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function update(Request $request, $id){
        $dataForm = $request->all();
        try{
            $disciplinas = Disciplina::find($id);
            $disciplinas->update($dataForm);
            $this->auditoriaController->storeUpdate($disciplinas, $disciplinas->id);

            $disciplinas = Disciplina::all();
            return view('admin/disciplinas/home', compact('disciplinas'));
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function destroy($id){
        try{
            $disciplina = Disciplina::find($id);
            $disciplina->delete($id);
            $this->auditoriaController->storeDelete($disciplina, $disciplina->id);

            $disciplinas = Disciplina::all();
            return view('admin/disciplinas/home', compact('disciplinas'));
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

}