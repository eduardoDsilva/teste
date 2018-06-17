<?php
/**
 * Created by PhpStorm.
 * User: eduardo.dgi
 * Date: 14/05/2018
 * Time: 09:49
 */

namespace App\Http\Controllers\Escola\Suplente;

use App\Aluno;
use App\Disciplina;
use App\Escola;
use App\Http\Controllers\Auditoria\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Professor;
use App\Suplente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class EscolaSuplenteController extends Controller
{

    private $auditoriaController;
    private $professor;
    private $escola;

    public function index()
    {
        $suplentes = Suplente::where('ano', '=', '2018')->paginate(10);

        return view('escola/suplente/home', compact('suplentes'));
    }

    public function __construct(AuditoriaController $auditoriaController, Professor $professor, Escola $escola)
    {
        $this->auditoriaController = $auditoriaController;
        $this->escola = $escola;
        $this->professor = $professor;
    }

    public function create(){
        $disciplinas = Disciplina::all();
        $escola = Escola::find(Auth::user()->escola->id);

        $suplentes = DB::table('suplentes')->select('categoria_id')->where('escola_id', '=', $escola->id)->get();
        $categoria_id = [];
        foreach($suplentes as $suplente){
            $categoria_id[] = $suplente->categoria_id;
        }
        $categorias = $escola->categoria->whereNotIn('id', $categoria_id);
        $professores = Professor::all()->where('escola_id', '=', Auth::user()->escola->id)->where('projeto_id', '=', null)->where('suplente_id', '=', null);

        return view("escola/suplente/cadastro", compact('disciplinas', 'escola', 'categorias', 'professores'));
    }

    public function store(\Illuminate\Support\Facades\Request $request){
        $dataForm = $request->all() + ['escola_id' => Auth::user()->escola->id];
        try{
            $escola = Escola::find(Auth::user()->escola->id);
            $suplente = Suplente::all()->where('escola_id', '=', $escola->id);
            if(count($suplente)>=$escola->projetos){
                dd('não pode mais cadastrar suplentes');
                }
            $suplente = Suplente::create($dataForm);

            foreach ($request->only(['disciplina_id']) as $disciplina) {
                $suplente->disciplina()->attach($disciplina);
            }

            foreach ($request->only(['aluno_id']) as $aluno_id) {
                $alunos = Aluno::find($aluno_id);
            }

            foreach ($alunos as $aluno) {
                $aluno->suplente_id = $suplente->id;
                $aluno->save();
            }

            $orientador = Professor::find($dataForm['orientador']);
            $orientador->suplente_id = $suplente->id;
            $orientador->tipo = 'orientador';
            $orientador->save();

            if (isset($dataForm['coorientador'])) {
                $coorientador = Professor::find($dataForm['coorientador']);
                $coorientador->suplente_id = $suplente->id;
                $coorientador->tipo = 'coorientador';
                $coorientador->save();
            }
            $suplentes = Suplente::where('ano', '=', '2018')->paginate(10);

            return view('escola/suplente/home', compact('suplentes', 'suplentes'));
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }

    }

    public function show($id){
        try{
            $suplente = Suplente::find($id);
            $alunos = Aluno::all()->where('suplente_id', '=', $suplente->id);
            $professores = Professor::all()->where('suplente_id', '=', $suplente->id);
            return view("escola/suplente/show", compact('suplente', 'alunos', 'professores'));
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function edit($id){
        try{
            $suplente = Suplente::find($id);
            $disciplinas = Disciplina::all();
            $titulo = 'Editar suplente: '.$suplente->titulo;
            return view("escola/suplente/editar", compact( 'suplente', 'titulo', 'disciplinas'));
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function update(\Illuminate\Support\Facades\Request $request, $id){
        $dataForm = $request->all();
        try{
            $suplente = Suplente::find($id);
            $suplente->update($dataForm);
            $suplente->disciplina()->detach();
            foreach ($request->only(['disciplina_id']) as $disciplina){
                $suplente->disciplina()->attach($disciplina);
            }
            $this->auditoriaController->storeUpdate(json_encode($suplente, JSON_UNESCAPED_UNICODE), $suplente->id);

            Session::put('mensagem', "O suplente ".$suplente->titulo." foi editado com sucesso!");

            return redirect()->route("escola/suplente/home");
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function destroy($id, $suplente){
        try{
            if($suplente == 'suplente'){
                DB::update('update alunos set suplente_id = ? where suplente_id = ?',[null,$id]);
                DB::update('update professores set suplente_id = ? where suplente_id = ?',[null,$id]);
                $suplente = Suplente::find($id);
                $suplente->delete($id);
                $this->auditoriaController->storeDelete(json_encode($suplente, JSON_UNESCAPED_UNICODE), $suplente->id);
            }else{
                DB::update('update alunos set suplente_id = ? where suplente_id = ?',[null,$id]);
                DB::update('update professores set suplente_id = ? where suplente_id = ?',[null,$id]);
                $suplente = Suplente::find($id);
                $suplente->delete($id);
                $this->auditoriaController->storeDelete(json_encode($suplente, JSON_UNESCAPED_UNICODE), $suplente->id);
            }
        }catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function categorias(){
        $escola_id = Input::get('escola_id');
        Session::put('escola_id', $escola_id);
        $escola = $this->escola->find($escola_id);
        $suplentes = DB::table('suplentes')->select('categoria_id')->where('escola_id', '=', $escola->id)->get();
        $categoria_id = [];
        foreach($suplentes as $suplente){
            $categoria_id[] = $suplente->categoria_id;
        }
        $categoria = $escola->categoria->whereNotIn('id', $categoria_id);

        return response()->json($categoria);
    }

    public function alunos(){
        $categoria_id = Input::get('categoria_id');
        $alunos = Aluno::where('escola_id', '=', Session::get('escola_id'))->where('categoria_id', '=', $categoria_id)->where('projeto_id', '=', null)->where('suplente_id', '=', null)->get();
        return response()->json($alunos);
    }

    public function professores(){
        $escola_id = Input::get('escola_id');
        $professores = Professor::where('escola_id', '=', $escola_id)->where('projeto_id', '=', null)->where('suplente_id', '=', null)->get();
        return response()->json($professores);
    }

}