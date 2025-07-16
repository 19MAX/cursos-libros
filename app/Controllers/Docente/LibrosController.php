<?php

namespace App\Controllers\Docente;

use App\Controllers\BaseController;
use App\Models\LibrosModel;
use CodeIgniter\HTTP\ResponseInterface;

class LibrosController extends BaseController
{
    protected $librosModel;
    protected $validation;

    public function __construct()
    {
        $this->librosModel = new LibrosModel();
        $this->validation = \Config\Services::validation();
        helper(['files']);
    }

    public function index()
    {
        $docenteId = session()->get('user_id') ?? 1;
        $libros = $this->librosModel->where('docente_id', $docenteId)->findAll();
        return view('docente/libros/index', [
            'libros' => $libros
        ]);
    }

    public function create()
    {
        return view('docente/libros/create');
    }

    private function processFile($file, $docenteId, $tipo = 'libro')
    {
        // Puedes adaptar este helper según tu lógica de almacenamiento
        $nombre = $tipo === 'portada' ? 'portada' : 'libro';
        $result = uploadLibroFile($file, $docenteId, $nombre);
        return $result;
    }

    public function store()
    {
        $validationRules = [
            'titulo_libro' => [
                'rules' => 'required|min_length[3]|max_length[500]',
                'errors' => [
                    'required' => 'El título es obligatorio.',
                    'min_length' => 'El título debe tener al menos 3 caracteres.',
                    'max_length' => 'El título no debe exceder 500 caracteres.'
                ]
            ],
            'autores' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar los autores.'
                ]
            ],
            'editorial' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar la editorial.'
                ]
            ],
            'fecha_publicacion' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de publicación es obligatoria.',
                    'valid_date' => 'La fecha no es válida.'
                ]
            ],
            'archivo_libro' => [
                'rules' => 'uploaded[archivo_libro]|max_size[archivo_libro,20480]',
                'errors' => [
                    'uploaded' => 'Debe subir el archivo del libro.',
                    'max_size' => 'El archivo no debe exceder 20MB.'
                ]
            ],
            'portada_libro' => [
                'rules' => 'uploaded[portada_libro]|max_size[portada_libro,5120]',
                'errors' => [
                    'uploaded' => 'Debe subir la portada del libro.',
                    'max_size' => 'La portada no debe exceder 5MB.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $docenteId = session()->get('user_id') ?? 1;
        $data = [
            'docente_id' => $docenteId,
            'titulo_libro' => $this->request->getPost('titulo_libro'),
            'subtitulo' => $this->request->getPost('subtitulo'),
            'autores' => $this->request->getPost('autores'),
            'editorial' => $this->request->getPost('editorial'),
            'isbn' => $this->request->getPost('isbn'),
            'isbn_electronico' => $this->request->getPost('isbn_electronico'),
            'edicion' => $this->request->getPost('edicion'),
            'numero_paginas' => $this->request->getPost('numero_paginas'),
            'fecha_publicacion' => $this->request->getPost('fecha_publicacion'),
            'pais_publicacion' => $this->request->getPost('pais_publicacion'),
            'ciudad_publicacion' => $this->request->getPost('ciudad_publicacion'),
            'tipo_libro' => $this->request->getPost('tipo_libro'),
            'area_conocimiento' => $this->request->getPost('area_conocimiento'),
            'disciplina' => $this->request->getPost('disciplina'),
            'resumen' => $this->request->getPost('resumen'),
            'palabras_clave' => $this->request->getPost('palabras_clave'),
            'indice' => $this->request->getPost('indice'),
            'prologo' => $this->request->getPost('prologo'),
            'enlace_editorial' => $this->request->getPost('enlace_editorial'),
            'certificacion_editorial' => $this->request->getPost('certificacion_editorial'),
            'impacto_academico' => $this->request->getPost('impacto_academico'),
            'citas_referenciadas' => $this->request->getPost('citas_referenciadas'),
            'puntaje_asignado' => 0.00,
            'estado' => 'pendiente',
            'observaciones' => $this->request->getPost('observaciones'),
            'created_by' => $docenteId
        ];

        // Procesar archivos
        $fileLibro = $this->request->getFile('archivo_libro');
        $filePortada = $this->request->getFile('portada_libro');

        $resultLibro = $this->processFile($fileLibro, $docenteId, 'libro');
        $resultPortada = $this->processFile($filePortada, $docenteId, 'portada');

        if (!$resultLibro['success']) {
            return redirect()->back()->withInput()->with('error', $resultLibro['message']);
        }
        if (!$resultPortada['success']) {
            return redirect()->back()->withInput()->with('error', $resultPortada['message']);
        }

        $data['archivo_libro'] = $resultLibro['path'];
        $data['portada_libro'] = $resultPortada['path'];

        $this->librosModel->db->transStart();
        try {
            $libroId = $this->librosModel->insert($data);
            if (!$libroId) {
                throw new \Exception('Error al crear el libro en la base de datos');
            }
            $this->librosModel->db->transComplete();
            if ($this->librosModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }
            return redirect()->to('docente/libros')->with('success', 'Libro creado exitosamente');
        } catch (\Exception $e) {
            $this->librosModel->db->transRollback();
            // Eliminar archivos subidos si hubo error
            if (isset($data['archivo_libro'])) deleteLibroFile($data['archivo_libro']);
            if (isset($data['portada_libro'])) deleteLibroFile($data['portada_libro']);
            return redirect()->back()->withInput()->with('error', 'Error interno del servidor: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $docenteId = session()->get('user_id') ?? 1;
        $libro = $this->librosModel->where('id', $id)->where('docente_id', $docenteId)->first();
        if (!$libro) {
            return redirect()->to('docente/libros')->with('error', 'Libro no encontrado');
        }
        if ($libro['estado'] !== 'pendiente') {
            return redirect()->to('docente/libros')->with('error', 'Solo se pueden editar libros con estado pendiente');
        }
        return view('docente/libros/edit', [
            'libro' => $libro
        ]);
    }

    public function update($id)
    {
        $docenteId = session()->get('user_id') ?? 1;
        $libro = $this->librosModel->where('id', $id)->where('docente_id', $docenteId)->first();
        if (!$libro) {
            return redirect()->to('docente/libros')->with('error', 'Libro no encontrado');
        }
        if ($libro['estado'] !== 'pendiente') {
            return redirect()->to('docente/libros')->with('error', 'Solo se pueden editar libros con estado pendiente');
        }
        $validationRules = [
            'titulo_libro' => [
                'rules' => 'required|min_length[3]|max_length[500]',
                'errors' => [
                    'required' => 'El título es obligatorio.',
                    'min_length' => 'El título debe tener al menos 3 caracteres.',
                    'max_length' => 'El título no debe exceder 500 caracteres.'
                ]
            ],
            'autores' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar los autores.'
                ]
            ],
            'editorial' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar la editorial.'
                ]
            ],
            'fecha_publicacion' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de publicación es obligatoria.',
                    'valid_date' => 'La fecha no es válida.'
                ]
            ]
        ];
        $fileLibro = $this->request->getFile('archivo_libro');
        $filePortada = $this->request->getFile('portada_libro');
        if ($fileLibro && $fileLibro->isValid() && !$fileLibro->hasMoved()) {
            $validationRules['archivo_libro'] = [
                'rules' => 'max_size[archivo_libro,20480]',
                'errors' => [
                    'max_size' => 'El archivo no debe exceder 20MB.'
                ]
            ];
        }
        if ($filePortada && $filePortada->isValid() && !$filePortada->hasMoved()) {
            $validationRules['portada_libro'] = [
                'rules' => 'max_size[portada_libro,5120]',
                'errors' => [
                    'max_size' => 'La portada no debe exceder 5MB.'
                ]
            ];
        }
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        $data = [
            'titulo_libro' => $this->request->getPost('titulo_libro'),
            'subtitulo' => $this->request->getPost('subtitulo'),
            'autores' => $this->request->getPost('autores'),
            'editorial' => $this->request->getPost('editorial'),
            'isbn' => $this->request->getPost('isbn'),
            'isbn_electronico' => $this->request->getPost('isbn_electronico'),
            'edicion' => $this->request->getPost('edicion'),
            'numero_paginas' => $this->request->getPost('numero_paginas'),
            'fecha_publicacion' => $this->request->getPost('fecha_publicacion'),
            'pais_publicacion' => $this->request->getPost('pais_publicacion'),
            'ciudad_publicacion' => $this->request->getPost('ciudad_publicacion'),
            'tipo_libro' => $this->request->getPost('tipo_libro'),
            'area_conocimiento' => $this->request->getPost('area_conocimiento'),
            'disciplina' => $this->request->getPost('disciplina'),
            'resumen' => $this->request->getPost('resumen'),
            'palabras_clave' => $this->request->getPost('palabras_clave'),
            'indice' => $this->request->getPost('indice'),
            'prologo' => $this->request->getPost('prologo'),
            'enlace_editorial' => $this->request->getPost('enlace_editorial'),
            'certificacion_editorial' => $this->request->getPost('certificacion_editorial'),
            'impacto_academico' => $this->request->getPost('impacto_academico'),
            'citas_referenciadas' => $this->request->getPost('citas_referenciadas'),
            'observaciones' => $this->request->getPost('observaciones'),
            'updated_by' => $docenteId
        ];
        if ($fileLibro && $fileLibro->isValid() && !$fileLibro->hasMoved()) {
            $resultLibro = $this->processFile($fileLibro, $docenteId, 'libro');
            if (!$resultLibro['success']) {
                return redirect()->back()->withInput()->with('error', $resultLibro['message']);
            }
            if (!empty($libro['archivo_libro'])) deleteLibroFile($libro['archivo_libro']);
            $data['archivo_libro'] = $resultLibro['path'];
        }
        if ($filePortada && $filePortada->isValid() && !$filePortada->hasMoved()) {
            $resultPortada = $this->processFile($filePortada, $docenteId, 'portada');
            if (!$resultPortada['success']) {
                return redirect()->back()->withInput()->with('error', $resultPortada['message']);
            }
            if (!empty($libro['portada_libro'])) deleteLibroFile($libro['portada_libro']);
            $data['portada_libro'] = $resultPortada['path'];
        }
        $this->librosModel->db->transStart();
        try {
            $updated = $this->librosModel->update($id, $data);
            if (!$updated) {
                throw new \Exception('Error al actualizar el libro en la base de datos');
            }
            $this->librosModel->db->transComplete();
            if ($this->librosModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }
            return redirect()->to('docente/libros')->with('success', 'Libro actualizado exitosamente');
        } catch (\Exception $e) {
            $this->librosModel->db->transRollback();
            if (isset($data['archivo_libro'])) deleteLibroFile($data['archivo_libro']);
            if (isset($data['portada_libro'])) deleteLibroFile($data['portada_libro']);
            return redirect()->back()->withInput()->with('error', 'Error interno del servidor: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $docenteId = session()->get('user_id') ?? 1;
        $libro = $this->librosModel->where('id', $id)->where('docente_id', $docenteId)->first();
        if (!$libro) {
            return redirect()->to('docente/libros')->with('error', 'Libro no encontrado');
        }
        if ($libro['estado'] !== 'pendiente') {
            return redirect()->to('docente/libros')->with('error', 'Solo se pueden eliminar libros con estado pendiente');
        }
        $this->librosModel->db->transStart();
        try {
            if (!empty($libro['archivo_libro'])) deleteLibroFile($libro['archivo_libro']);
            if (!empty($libro['portada_libro'])) deleteLibroFile($libro['portada_libro']);
            $deleted = $this->librosModel->delete($id);
            if (!$deleted) {
                throw new \Exception('Error al eliminar el libro de la base de datos');
            }
            $this->librosModel->db->transComplete();
            if ($this->librosModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }
            return redirect()->to('docente/libros')->with('success', 'Libro eliminado exitosamente');
        } catch (\Exception $e) {
            $this->librosModel->db->transRollback();
            return redirect()->to('docente/libros')->with('error', 'Error al eliminar el libro: ' . $e->getMessage());
        }
    }
} 