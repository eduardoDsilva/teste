<?php
/**
 * Created by PhpStorm.
 * User: eduardo.dgi
 * Date: 20/07/2018
 * Time: 10:17
 */

namespace App\Http\Controllers\Audit;

use App\Audit;
use App\Exports\InvoicesExport;
use App\Exports\InvoicesExportByUser;
use App\User;
use Maatwebsite\Excel\Facades\Excel;

class AuditController
{

    public function index(){
        $auditorias = Audit::latest()->paginate(10);
        return view('admin.auditoria.home', compact('auditorias'));
    }

    public function relatorios(){
        $usuarios = User::paginate(10);
        return view('admin.auditoria.relatorios', compact('usuarios'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'audit.xlsx');
    }

    public function exportByUser($id)
    {
        return Excel::download(new InvoicesExportByUser($id), 'audit-user:'.$id.'.xlsx');
    }

    public function filtrarUsuarios(Request $request)
    {
        $dataForm = $request->all();
        $modal2 = true;
        try {
            if ($dataForm['tipo'] == 'id') {
                $usuarios = User::where('id', '=', $dataForm['search'])->paginate(10);
            } else if ($dataForm['tipo'] == 'nome') {
                $filtro = '%' . $dataForm['search'] . '%';
                $usuarios = User::where('name', 'like', $filtro)->paginate(10);
            } else if ($dataForm['tipo'] == 'username') {
                $filtro = '%' . $dataForm['search'] . '%';
                $usuarios = User::where('username', '=', $filtro)->paginate(10);
            }
            return view('admin.auditoria.relatorios', compact('usuarios', 'modal2'));
        } catch (\Exception $e) {
            return "ERRO: " . $e->getMessage();
        }
    }

    public function filtrar(\Illuminate\Http\Request $request)
    {
        try {
            $dataForm = $request->all();
            if ($dataForm['tipo'] == 'id') {
                $auditorias = Audit::where('id', '=', $dataForm['search'])->paginate(10);
            } else if ($dataForm['tipo'] == 'tipo') {
                $filtro = '%' . $dataForm['search'] . '%';
                $auditorias = Audit::where('auditable_type', 'like', $filtro)->paginate(10);
            } else if ($dataForm['tipo'] == 'evento') {
                $filtro = '%' . $dataForm['search'] . '%';
                $auditorias = Audit::where('event', 'like', $filtro)->paginate(10);
            } else if ($dataForm['tipo'] == 'user') {
                $user = User::where('username', '=', $dataForm['search'])->first();
                $auditorias = Audit::where('user_id', 'like', $user->id)->paginate(10);
            }
            return view('admin.auditoria.home', compact('auditorias'));
        } catch (\Exception $e) {
            return "Erro " . $e->getMessage();
        }
    }

}