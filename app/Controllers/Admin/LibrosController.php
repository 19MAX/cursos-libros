<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LibrosModel;
use App\Models\UsersModel;

class LibrosController extends BaseController
{
    protected $librosModel;

    public function __construct()
    {
        $this->librosModel = new LibrosModel();
    }

    public function index()
    {
        $libros = $this->librosModel->orderBy('created_at', 'DESC')->findAll();
        $usersModel = new UsersModel();
        foreach ($libros as &$l) {
            $user = $usersModel->find($l['docente_id']);
            $l['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        }
        return view('admin/libros/index', [
            'libros' => $libros
        ]);
    }

    public function show($id)
    {
        $libro = $this->librosModel->find($id);
        if (!$libro) {
            return redirect()->to(base_url('admin/libros'))->with('error', 'Libro no encontrado.');
        }
        $usersModel = new UsersModel();
        $user = $usersModel->find($libro['docente_id']);
        $libro['docente_nombre'] = $user ? (trim(($user['name'] ?? '').' '.($user['surname'] ?? '')) ?: 'Sin nombre') : 'Desconocido';
        return view('admin/libros/show', [
            'libro' => $libro
        ]);
    }

    public function aprobar($id)
    {
        $libro = $this->librosModel->find($id);
        if (!$libro) {
            return redirect()->to(base_url('admin/libros'))->with('error', 'Libro no encontrado.');
        }
        $puntaje = $this->request->getPost('puntaje_asignado');
        if (!is_numeric($puntaje) || $puntaje < 0) {
            return redirect()->back()->with('error', 'El puntaje debe ser un número positivo.');
        }
        $this->librosModel->update($id, [
            'estado' => 'aprobado',
            'puntaje_asignado' => $puntaje,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/libros'))->with('success', 'Libro aprobado correctamente.');
    }

    public function rechazar($id)
    {
        $libro = $this->librosModel->find($id);
        if (!$libro) {
            return redirect()->to(base_url('admin/libros'))->with('error', 'Libro no encontrado.');
        }
        $this->librosModel->update($id, [
            'estado' => 'rechazado',
            'puntaje_asignado' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->to(base_url('admin/libros'))->with('success', 'Libro rechazado correctamente.');
    }
} 