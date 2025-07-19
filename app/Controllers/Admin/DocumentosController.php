<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DocumentosModel;
use App\Models\UsersModel;

class DocumentosController extends BaseController
{
    protected $documentosModel;

    public function __construct()
    {
        $this->documentosModel = new DocumentosModel();
    }

    public function index()
    {
        $documentos = $this->documentosModel->orderBy('created_at', 'DESC')->findAll();
        $usersModel = new UsersModel();
        foreach ($documentos as &$d) {
            $user = $usersModel->find($d['docente_id']);
            $d['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        }
        return view('admin/documentos/index', [
            'documentos' => $documentos
        ]);
    }

    public function show($id)
    {
        $documento = $this->documentosModel->find($id);
        if (!$documento) {
            return redirect()->to(base_url('admin/documentos'))->with('error', 'Documento no encontrado.');
        }
        $usersModel = new UsersModel();
        $user = $usersModel->find($documento['docente_id']);
        $documento['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        return view('admin/documentos/show', [
            'documento' => $documento
        ]);
    }

    public function aprobar($id)
    {
        $documento = $this->documentosModel->find($id);
        if (!$documento) {
            return redirect()->to(base_url('admin/documentos'))->with('error', 'Documento no encontrado.');
        }
        $puntaje = $this->request->getPost('puntaje_asignado');
        if (!is_numeric($puntaje) || $puntaje < 0) {
            return redirect()->back()->with('error', 'El puntaje debe ser un número positivo.');
        }
        $this->documentosModel->update($id, [
            'estado' => 'aprobado',
            'puntaje_asignado' => $puntaje,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/documentos'))->with('success', 'Documento aprobado correctamente.');
    }

    public function rechazar($id)
    {
        $documento = $this->documentosModel->find($id);
        if (!$documento) {
            return redirect()->to(base_url('admin/documentos'))->with('error', 'Documento no encontrado.');
        }
        $this->documentosModel->update($id, [
            'estado' => 'rechazado',
            'puntaje_asignado' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/documentos'))->with('success', 'Documento rechazado correctamente.');
    }
} 