<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class DocentesController extends BaseController
{
    public function index()
    {
        $usersModel = new UsersModel();
        $docentes = $usersModel->where('role', 2)->findAll();
        return view('admin/docentes/index', ['docentes' => $docentes]);
    }

    public function create()
    {
        return view('admin/docentes/create');
    }

    public function store()
    {
        $usersModel = new UsersModel();
        $data = [
            'ci' => $this->request->getPost('ci'),
            'name' => $this->request->getPost('name'),
            'surname' => $this->request->getPost('surname'),
            'email' => $this->request->getPost('email'),
            'role' => 2,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        // Validar email y ci únicos
        if ($usersModel->where('email', $data['email'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El correo electrónico ya está registrado.');
        }
        if ($usersModel->where('ci', $data['ci'])->first()) {
            return redirect()->back()->withInput()->with('error', 'La cédula ya está registrada.');
        }
        $usersModel->insert($data);
        return redirect()->to(base_url('admin/docentes'))->with('success', 'Docente creado correctamente.');
    }

    public function edit($id)
    {
        $usersModel = new UsersModel();
        $docente = $usersModel->find($id);
        if (!$docente || $docente['role'] != 2) {
            return redirect()->to(base_url('admin/docentes'))->with('error', 'Docente no encontrado.');
        }
        return view('admin/docentes/edit', ['docente' => $docente]);
    }

    public function update($id)
    {
        $usersModel = new UsersModel();
        $docente = $usersModel->find($id);
        if (!$docente || $docente['role'] != 2) {
            return redirect()->to(base_url('admin/docentes'))->with('error', 'Docente no encontrado.');
        }
        $data = [
            'ci' => $this->request->getPost('ci'),
            'name' => $this->request->getPost('name'),
            'surname' => $this->request->getPost('surname'),
            'email' => $this->request->getPost('email'),
        ];
        // Validar email y ci únicos si cambiaron
        if ($docente['email'] != $data['email'] && $usersModel->where('email', $data['email'])->first()) {
            return redirect()->back()->withInput()->with('error', 'El correo electrónico ya está registrado.');
        }
        if ($docente['ci'] != $data['ci'] && $usersModel->where('ci', $data['ci'])->first()) {
            return redirect()->back()->withInput()->with('error', 'La cédula ya está registrada.');
        }
        $usersModel->update($id, $data);
        return redirect()->to(base_url('admin/docentes'))->with('success', 'Docente actualizado correctamente.');
    }

    public function delete($id)
    {
        $usersModel = new UsersModel();
        $docente = $usersModel->find($id);
        if (!$docente || $docente['role'] != 2) {
            return redirect()->to(base_url('admin/docentes'))->with('error', 'Docente no encontrado.');
        }
        $usersModel->delete($id);
        return redirect()->to(base_url('admin/docentes'))->with('success', 'Docente eliminado correctamente.');
    }
} 