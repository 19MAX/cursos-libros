<?php

namespace App\Controllers\Docente;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LibrosModel;
use App\Models\ArticulosModel;
use App\Models\CapacitacionesModel;
use App\Models\DocumentosModel;
use CodeIgniter\I18n\Time;

class DashboardController extends BaseController
{
    public function index()
    {
        $docenteId = session()->get('user_id');
        $librosModel = new LibrosModel();
        $articulosModel = new ArticulosModel();
        $capacitacionesModel = new CapacitacionesModel();
        $documentosModel = new DocumentosModel();

        // Estadísticas generales
        $totalLibros = $librosModel->where('docente_id', $docenteId)->countAllResults();
        $totalArticulos = $articulosModel->where('docente_id', $docenteId)->countAllResults();
        $totalCapacitaciones = $capacitacionesModel->where('docente_id', $docenteId)->countAllResults();
        $totalDocumentos = $documentosModel->where('docente_id', $docenteId)->countAllResults();
        $puntajeTotal = $capacitacionesModel->where('docente_id', $docenteId)->selectSum('puntaje_asignado')->first()['puntaje_asignado']
            + $librosModel->where('docente_id', $docenteId)->selectSum('puntaje_asignado')->first()['puntaje_asignado']
            + $articulosModel->where('docente_id', $docenteId)->selectSum('puntaje_asignado')->first()['puntaje_asignado']
            + $documentosModel->where('docente_id', $docenteId)->selectSum('puntaje_asignado')->first()['puntaje_asignado'];

        // Mes actual
        $now = Time::now();
        $mes = $now->getMonth();
        $anio = $now->getYear();
        $inicioMes = $anio.'-'.str_pad($mes,2,'0',STR_PAD_LEFT).'-01 00:00:00';
        $finMes = $anio.'-'.str_pad($mes,2,'0',STR_PAD_LEFT).'-31 23:59:59';

        $librosMes = $librosModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();
        $articulosMes = $articulosModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();
        $capacitacionesMes = $capacitacionesModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();
        $documentosMes = $documentosModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();

        return view('docente/index', [
            'totalLibros' => $totalLibros,
            'totalArticulos' => $totalArticulos,
            'totalCapacitaciones' => $totalCapacitaciones,
            'totalDocumentos' => $totalDocumentos,
            'puntajeTotal' => $puntajeTotal,
            'librosMes' => $librosMes,
            'articulosMes' => $articulosMes,
            'capacitacionesMes' => $capacitacionesMes,
            'documentosMes' => $documentosMes,
            'mes' => $mes,
            'anio' => $anio
        ]);
    }

    public function perfil()
    {
        $docenteId = session()->get('user_id');
        $usersModel = new \App\Models\UsersModel();
        $docente = $usersModel->find($docenteId);
        return view('docente/perfil', ['docente' => $docente]);
    }

    public function updatePerfil()
    {
        $docenteId = session()->get('user_id');
        $usersModel = new \App\Models\UsersModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'surname' => $this->request->getPost('surname'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
        ];
        $usersModel->update($docenteId, $data);
        return redirect()->to(base_url('docente/perfil'))->with('success', 'Perfil actualizado correctamente.');
    }
}
