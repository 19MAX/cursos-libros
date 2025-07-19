<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\LibrosModel;
use App\Models\ArticulosModel;
use App\Models\CapacitacionesModel;
use App\Models\DocumentosModel;
use CodeIgniter\I18n\Time;

class DashboardController extends BaseController
{
    public function index()
    {
        $usersModel = new UsersModel();
        $librosModel = new LibrosModel();
        $articulosModel = new ArticulosModel();
        $capacitacionesModel = new CapacitacionesModel();
        $documentosModel = new DocumentosModel();

        $totalDocentes = $usersModel->where('role', 2)->countAllResults(); // Asumiendo 2 = Docente
        $totalLibros = $librosModel->countAllResults();
        $totalArticulos = $articulosModel->countAllResults();
        $totalCapacitaciones = $capacitacionesModel->countAllResults();
        $totalDocumentos = $documentosModel->countAllResults();

        // Filtro de docente (por GET o el primero)
        $docenteId = $this->request->getGet('docente_id');
        $docentes = $usersModel->where('role', 2)->findAll();
        if (!$docenteId && count($docentes) > 0) {
            $docenteId = $docentes[0]['id'];
        }

        // Mes actual
        $now = Time::now();
        $mes = $now->getMonth();
        $anio = $now->getYear();
        $inicioMes = $anio.'-'.str_pad($mes,2,'0',STR_PAD_LEFT).'-01 00:00:00';
        $finMes = $anio.'-'.str_pad($mes,2,'0',STR_PAD_LEFT).'-31 23:59:59';

        // Estadísticas por docente y mes
        $librosDocente = $librosModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();
        $articulosDocente = $articulosModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();
        $capacitacionesDocente = $capacitacionesModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();
        $documentosDocente = $documentosModel->where('docente_id', $docenteId)
            ->where('created_at >=', $inicioMes)
            ->where('created_at <=', $finMes)
            ->countAllResults();

        return view('admin/index', [
            'totalDocentes' => $totalDocentes,
            'totalLibros' => $totalLibros,
            'totalArticulos' => $totalArticulos,
            'totalCapacitaciones' => $totalCapacitaciones,
            'totalDocumentos' => $totalDocumentos,
            'docentes' => $docentes,
            'docenteId' => $docenteId,
            'librosDocente' => $librosDocente,
            'articulosDocente' => $articulosDocente,
            'capacitacionesDocente' => $capacitacionesDocente,
            'documentosDocente' => $documentosDocente,
            'mes' => $mes,
            'anio' => $anio
        ]);
    }
}
