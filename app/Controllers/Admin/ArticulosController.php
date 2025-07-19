<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArticulosModel;
use App\Models\UsersModel;

class ArticulosController extends BaseController
{
    protected $articulosModel;

    public function __construct()
    {
        $this->articulosModel = new ArticulosModel();
    }

    public function index()
    {
        $articulos = $this->articulosModel->orderBy('created_at', 'DESC')->findAll();
        $usersModel = new UsersModel();
        foreach ($articulos as &$a) {
            $user = $usersModel->find($a['docente_id']);
            $a['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        }
        return view('admin/articulos/index', [
            'articulos' => $articulos
        ]);
    }

    public function show($id)
    {
        $articulo = $this->articulosModel->find($id);
        if (!$articulo) {
            return redirect()->to(base_url('admin/articulos'))->with('error', 'Artículo no encontrado.');
        }
        $usersModel = new UsersModel();
        $user = $usersModel->find($articulo['docente_id']);
        $articulo['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        return view('admin/articulos/show', [
            'articulo' => $articulo
        ]);
    }

    public function aprobar($id)
    {
        $articulo = $this->articulosModel->find($id);
        if (!$articulo) {
            return redirect()->to(base_url('admin/articulos'))->with('error', 'Artículo no encontrado.');
        }
        $puntaje = $this->request->getPost('puntaje_asignado');
        if (!is_numeric($puntaje) || $puntaje < 0) {
            return redirect()->back()->with('error', 'El puntaje debe ser un número positivo.');
        }
        $this->articulosModel->update($id, [
            'estado' => 'aprobado',
            'puntaje_asignado' => $puntaje,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/articulos'))->with('success', 'Artículo aprobado correctamente.');
    }

    public function rechazar($id)
    {
        $articulo = $this->articulosModel->find($id);
        if (!$articulo) {
            return redirect()->to(base_url('admin/articulos'))->with('error', 'Artículo no encontrado.');
        }
        $this->articulosModel->update($id, [
            'estado' => 'rechazado',
            'puntaje_asignado' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/articulos'))->with('success', 'Artículo rechazado correctamente.');
    }
} 