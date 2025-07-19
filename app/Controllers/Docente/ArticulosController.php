<?php

namespace App\Controllers\Docente;

use App\Controllers\BaseController;
use App\Models\ArticulosModel;
use App\Models\UsersModel;

class ArticulosController extends BaseController
{
    protected $articulosModel;
    protected $validation;

    public function __construct()
    {
        $this->articulosModel = new ArticulosModel();
        $this->validation = \Config\Services::validation();
        helper('files');
    }

    public function index()
    {
        $docenteId = session('user_id');
        $articulos = $this->articulosModel->where('docente_id', $docenteId)->findAll();
        // Estadísticas para la vista
        $estadisticas = [
            'total' => count($articulos),
            'aprobados' => count(array_filter($articulos, fn($a) => $a['estado'] === 'aprobado')),
            'pendientes' => count(array_filter($articulos, fn($a) => $a['estado'] === 'pendiente')),
            'rechazados' => count(array_filter($articulos, fn($a) => $a['estado'] === 'rechazado')),
        ];
        return view('docente/articulos/index', [
            'articulos' => $articulos,
            'estadisticas' => $estadisticas
        ]);
    }

    public function create()
    {
        return view('docente/articulos/create');
    }

    public function store()
    {
        $validationRules = [
            'titulo_articulo' => 'required|min_length[3]|max_length[500]',
            'autores' => 'required',
            'revista' => 'required',
            'fecha_publicacion' => 'required|valid_date',
            'tipo_revision' => 'required|in_list[Revisión doble ciego (Double-blind review),Revisión simple ciego (Single-blind review),Revisión abierta (Open review),Revisión colaborativa (Collaborative review),Revisión por la comunidad o post-publicación (Public/Community review),Revisión editorial (Editorial review)]',
            'tipo_articulo' => 'required|in_list[Artículo de investigación,Artículo de revisión,Preprint,Artículo técnico,Artículo de opinión / ensayo,Estudio de caso,Meta-análisis]',
            'cuartil' => 'required|in_list[Q1,Q2,Q3,Q4]',
            'archivo_articulo' => 'uploaded[archivo_articulo]|max_size[archivo_articulo,20480]',
        ];
        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        $data = $this->request->getPost();
        $data['docente_id'] = session('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['estado'] = 'pendiente';
        // Asegurar que los campos nuevos estén presentes aunque sean null
        $data['campo_amplio'] = $this->request->getPost('campo_amplio');
        $data['campo_especifico'] = $this->request->getPost('campo_especifico');
        $data['campo_detallado'] = $this->request->getPost('campo_detallado');
        // Subir archivo principal
        $file = $this->request->getFile('archivo_articulo');
        $fileResult = uploadArticuloFile($file, $data['docente_id'], 'articulo');
        if (!$fileResult['success']) {
            return redirect()->back()->withInput()->with('error', $fileResult['message']);
        }
        $data['archivo_articulo'] = $fileResult['path'];
        // Subir portada si existe
        $portada = $this->request->getFile('portada_articulo');
        if ($portada && $portada->isValid() && !$portada->hasMoved()) {
            $portadaResult = uploadArticuloFile($portada, $data['docente_id'], 'portada');
            if (!$portadaResult['success']) {
                return redirect()->back()->withInput()->with('error', $portadaResult['message']);
            }
            $data['portada_articulo'] = $portadaResult['path'];
        }
        $this->articulosModel->insert($data);
        return redirect()->to(base_url('docente/articulos'))->with('success', 'Artículo registrado correctamente.');
    }

    public function edit($id)
    {
        $docenteId = session('user_id');
        $articulo = $this->articulosModel->where('docente_id', $docenteId)->find($id);
        if (!$articulo) {
            return redirect()->to(base_url('docente/articulos'))->with('error', 'Artículo no encontrado.');
        }
        if ($articulo['estado'] !== 'pendiente') {
            return redirect()->to(base_url('docente/articulos'))->with('error', 'Solo se pueden editar artículos con estado pendiente.');
        }
        return view('docente/articulos/edit', [
            'articulo' => $articulo,
        ]);
    }

    public function update($id)
    {
        $docenteId = session('user_id');
        $articulo = $this->articulosModel->where('docente_id', $docenteId)->find($id);
        if (!$articulo) {
            return redirect()->to(base_url('docente/articulos'))->with('error', 'Artículo no encontrado.');
        }
        if ($articulo['estado'] !== 'pendiente') {
            return redirect()->to(base_url('docente/articulos'))->with('error', 'Solo se pueden editar artículos con estado pendiente.');
        }
        $validationRules = [
            'titulo_articulo' => 'required|min_length[3]|max_length[500]',
            'autores' => 'required',
            'revista' => 'required',
            'fecha_publicacion' => 'required|valid_date',
            'tipo_revision' => 'required|in_list[Revisión doble ciego (Double-blind review),Revisión simple ciego (Single-blind review),Revisión abierta (Open review),Revisión colaborativa (Collaborative review),Revisión por la comunidad o post-publicación (Public/Community review),Revisión editorial (Editorial review)]',
            'tipo_articulo' => 'required|in_list[Artículo de investigación,Artículo de revisión,Preprint,Artículo técnico,Artículo de opinión / ensayo,Estudio de caso,Meta-análisis]',
            'cuartil' => 'required|in_list[Q1,Q2,Q3,Q4]',
        ];
        $file = $this->request->getFile('archivo_articulo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $validationRules['archivo_articulo'] = 'max_size[archivo_articulo,20480]';
        }
        $portada = $this->request->getFile('portada_articulo');
        if ($portada && $portada->isValid() && !$portada->hasMoved()) {
            $validationRules['portada_articulo'] = 'max_size[portada_articulo,5120]';
        }
        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        $data = $this->request->getPost();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['campo_amplio'] = $this->request->getPost('campo_amplio');
        $data['campo_especifico'] = $this->request->getPost('campo_especifico');
        $data['campo_detallado'] = $this->request->getPost('campo_detallado');
        // Procesar archivo principal si se subió uno nuevo
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileResult = uploadArticuloFile($file, $docenteId, 'articulo');
            if (!$fileResult['success']) {
                return redirect()->back()->withInput()->with('error', $fileResult['message']);
            }
            // Eliminar archivo anterior si existe
            if (!empty($articulo['archivo_articulo'])) {
                deleteArticuloFile($articulo['archivo_articulo']);
            }
            $data['archivo_articulo'] = $fileResult['path'];
        }
        // Procesar portada si se subió una nueva
        if ($portada && $portada->isValid() && !$portada->hasMoved()) {
            $portadaResult = uploadArticuloFile($portada, $docenteId, 'portada');
            if (!$portadaResult['success']) {
                return redirect()->back()->withInput()->with('error', $portadaResult['message']);
            }
            // Eliminar portada anterior si existe
            if (!empty($articulo['portada_articulo'])) {
                deleteArticuloFile($articulo['portada_articulo']);
            }
            $data['portada_articulo'] = $portadaResult['path'];
        }
        $this->articulosModel->update($id, $data);
        return redirect()->to(base_url('docente/articulos'))->with('success', 'Artículo actualizado correctamente.');
    }

    public function delete($id)
    {
        $docenteId = session('user_id');
        $articulo = $this->articulosModel->where('docente_id', $docenteId)->find($id);
        if (!$articulo) {
            return redirect()->to(base_url('docente/articulos'))->with('error', 'Artículo no encontrado.');
        }
        if ($articulo['estado'] !== 'pendiente') {
            return redirect()->to(base_url('docente/articulos'))->with('error', 'Solo se pueden eliminar artículos con estado pendiente.');
        }
        // Eliminar archivos asociados
        if (!empty($articulo['archivo_articulo'])) {
            deleteArticuloFile($articulo['archivo_articulo']);
        }
        if (!empty($articulo['portada_articulo'])) {
            deleteArticuloFile($articulo['portada_articulo']);
        }
        $this->articulosModel->delete($id);
        return redirect()->to(base_url('docente/articulos'))->with('success', 'Artículo eliminado correctamente.');
    }
}