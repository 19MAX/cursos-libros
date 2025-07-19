<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CapacitacionesModel;
use App\Models\UsersModel;

class CapacitacionesController extends BaseController
{
    protected $capacitacionesModel;

    public function __construct()
    {
        $this->capacitacionesModel = new CapacitacionesModel();
    }

    public function index()
    {
        $capacitaciones = $this->capacitacionesModel->orderBy('created_at', 'DESC')->findAll();
        $usersModel = new UsersModel();
        // Mapear docente_id a nombre
        foreach ($capacitaciones as &$c) {
            $user = $usersModel->find($c['docente_id']);
            $c['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        }
        return view('admin/capacitaciones/index', [
            'capacitaciones' => $capacitaciones
        ]);
    }

    public function show($id)
    {
        $capacitacion = $this->capacitacionesModel->find($id);
        if (!$capacitacion) {
            return redirect()->to(base_url('admin/capacitaciones'))->with('error', 'Capacitación no encontrada.');
        }
        $usersModel = new UsersModel();
        $user = $usersModel->find($capacitacion['docente_id']);
        $capacitacion['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        return view('admin/capacitaciones/show', [
            'capacitacion' => $capacitacion
        ]);
    }

    public function aprobar($id)
    {
        $capacitacion = $this->capacitacionesModel->find($id);
        if (!$capacitacion) {
            return redirect()->to(base_url('admin/capacitaciones'))->with('error', 'Capacitación no encontrada.');
        }
        $puntaje = $this->request->getPost('puntaje_asignado');
        if (!is_numeric($puntaje) || $puntaje < 0) {
            return redirect()->back()->with('error', 'El puntaje debe ser un número positivo.');
        }
        $this->capacitacionesModel->update($id, [
            'estado' => 'aprobado',
            'puntaje_asignado' => $puntaje,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/capacitaciones'))->with('success', 'Capacitación aprobada correctamente.');
    }

    public function rechazar($id)
    {
        $capacitacion = $this->capacitacionesModel->find($id);
        if (!$capacitacion) {
            return redirect()->to(base_url('admin/capacitaciones'))->with('error', 'Capacitación no encontrada.');
        }
        $puntaje = $this->request->getPost('puntaje_asignado');
        if (!is_numeric($puntaje) || $puntaje < 0) {
            return redirect()->back()->with('error', 'El puntaje debe ser un número positivo.');
        }
        $this->capacitacionesModel->update($id, [
            'estado' => 'rechazado',
            'puntaje_asignado' => $puntaje,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/capacitaciones'))->with('success', 'Capacitación rechazada correctamente.');
    }
} 