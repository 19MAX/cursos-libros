<?php

namespace App\Controllers\Docente;

use App\Controllers\BaseController;
use App\Models\DocumentosModel;
use CodeIgniter\HTTP\ResponseInterface;

class DocumentosController extends BaseController
{
    protected $documentosModel;
    protected $validation;

    public function __construct()
    {
        $this->documentosModel = new DocumentosModel();
        $this->validation = \Config\Services::validation();
        helper(['files']);
    }

    public function index()
    {
        $docenteId = session()->get('user_id') ?? 1;
        $documentos = $this->documentosModel->getDocumentosByDocente($docenteId);
        
        return view('docente/documentos/index', [
            'documentos' => $documentos
        ]);
    }

    public function create()
    {
        return view('docente/documentos/create');
    }

    private function processFile($file, $docenteId)
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return ['success' => false, 'message' => 'Archivo no válido o ya procesado'];
        }
        
        $uploadPath = ROOTPATH . 'public/uploads/' . $docenteId . '/documentos/';
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0755, true)) {
                return ['success' => false, 'message' => 'Error al crear el directorio de destino'];
            }
        }
        
        $allowedTypes = ['pdf'];
        $extension = strtolower($file->getClientExtension());
        if (!in_array($extension, $allowedTypes)) {
            return [
                'success' => false,
                'message' => 'Solo se permiten archivos PDF'
            ];
        }
        
        $maxSize = 20 * 1024 * 1024; // 20MB
        if ($file->getSize() > $maxSize) {
            return [
                'success' => false,
                'message' => 'El archivo no debe exceder 20MB'
            ];
        }
        
        try {
            $timestamp = time();
            $fileName = 'documento_' . $timestamp . '.' . $extension;
            
            if (!$file->move($uploadPath, $fileName)) {
                return [
                    'success' => false,
                    'message' => 'Error al mover el archivo al directorio de destino'
                ];
            }
            
            $fullPath = $uploadPath . $fileName;
            if (!file_exists($fullPath)) {
                return [
                    'success' => false,
                    'message' => 'Error: El archivo no se guardó correctamente'
                ];
            }
            
            $relativePath = 'uploads/' . $docenteId . '/documentos/' . $fileName;
            return [
                'success' => true,
                'path' => $relativePath,
                'filename' => $fileName,
                'message' => 'Archivo subido exitosamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ];
        }
    }

    public function store()
    {
        $validationRules = [
            'nombre' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'El nombre del documento es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                    'max_length' => 'El nombre no debe exceder 255 caracteres.'
                ]
            ],
            'descripcion' => [
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'La descripción no debe exceder 1000 caracteres.'
                ]
            ],
            'guia' => [
                'rules' => 'uploaded[guia]|max_size[guia,20480]',
                'errors' => [
                    'uploaded' => 'Debe subir el archivo PDF de la guía.',
                    'max_size' => 'El archivo no debe exceder 20MB.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $docenteId = session()->get('user_id') ?? 1;
        $data = [
            'docente_id' => $docenteId,
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'puntaje_asignado' => 0.00,
            'estado' => 'pendiente',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Procesar archivo
        $fileGuia = $this->request->getFile('guia');
        $resultGuia = $this->processFile($fileGuia, $docenteId);

        if (!$resultGuia['success']) {
            return redirect()->back()->withInput()->with('error', $resultGuia['message']);
        }

        $data['guia'] = $resultGuia['path'];

        $this->documentosModel->db->transStart();
        try {
            $documentoId = $this->documentosModel->insert($data);
            if (!$documentoId) {
                throw new \Exception('Error al crear el documento en la base de datos');
            }
            $this->documentosModel->db->transComplete();
            if ($this->documentosModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }
            return redirect()->to('docente/documentos')->with('success', 'Documento creado exitosamente');
        } catch (\Exception $e) {
            $this->documentosModel->db->transRollback();
            // Eliminar archivo subido si hubo error
            if (isset($data['guia'])) {
                $fullPath = FCPATH . $data['guia'];
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return redirect()->back()->withInput()->with('error', 'Error interno del servidor: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $docenteId = session()->get('user_id') ?? 1;
        $documento = $this->documentosModel->getDocumentoByDocente($id, $docenteId);
        
        if (!$documento) {
            return redirect()->to('docente/documentos')->with('error', 'Documento no encontrado');
        }
        
        if ($documento['estado'] !== 'pendiente') {
            return redirect()->to('docente/documentos')->with('error', 'Solo se pueden editar documentos con estado pendiente');
        }
        
        return view('docente/documentos/edit', [
            'documento' => $documento
        ]);
    }

    public function update($id)
    {
        $docenteId = session()->get('user_id') ?? 1;
        $documento = $this->documentosModel->getDocumentoByDocente($id, $docenteId);
        
        if (!$documento) {
            return redirect()->to('docente/documentos')->with('error', 'Documento no encontrado');
        }
        
        if ($documento['estado'] !== 'pendiente') {
            return redirect()->to('docente/documentos')->with('error', 'Solo se pueden editar documentos con estado pendiente');
        }

        $validationRules = [
            'nombre' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'El nombre del documento es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                    'max_length' => 'El nombre no debe exceder 255 caracteres.'
                ]
            ],
            'descripcion' => [
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'La descripción no debe exceder 1000 caracteres.'
                ]
            ]
        ];

        $fileGuia = $this->request->getFile('guia');
        if ($fileGuia && $fileGuia->isValid() && !$fileGuia->hasMoved()) {
            $validationRules['guia'] = [
                'rules' => 'max_size[guia,20480]',
                'errors' => [
                    'max_size' => 'El archivo no debe exceder 20MB.'
                ]
            ];
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Procesar archivo si se subió uno nuevo
        if ($fileGuia && $fileGuia->isValid() && !$fileGuia->hasMoved()) {
            $resultGuia = $this->processFile($fileGuia, $docenteId);
            if (!$resultGuia['success']) {
                return redirect()->back()->withInput()->with('error', $resultGuia['message']);
            }
            
            // Eliminar archivo anterior
            if (!empty($documento['guia'])) {
                $oldFilePath = FCPATH . $documento['guia'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            
            $data['guia'] = $resultGuia['path'];
        }

        $this->documentosModel->db->transStart();
        try {
            $updated = $this->documentosModel->update($id, $data);
            if (!$updated) {
                throw new \Exception('Error al actualizar el documento en la base de datos');
            }
            $this->documentosModel->db->transComplete();
            if ($this->documentosModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }
            return redirect()->to('docente/documentos')->with('success', 'Documento actualizado exitosamente');
        } catch (\Exception $e) {
            $this->documentosModel->db->transRollback();
            if (isset($data['guia'])) {
                $fullPath = FCPATH . $data['guia'];
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            return redirect()->back()->withInput()->with('error', 'Error interno del servidor: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $docenteId = session()->get('user_id') ?? 1;
        $documento = $this->documentosModel->getDocumentoByDocente($id, $docenteId);
        
        if (!$documento) {
            return redirect()->to('docente/documentos')->with('error', 'Documento no encontrado');
        }
        
        if ($documento['estado'] !== 'pendiente') {
            return redirect()->to('docente/documentos')->with('error', 'Solo se pueden eliminar documentos con estado pendiente');
        }

        $this->documentosModel->db->transStart();
        try {
            // Eliminar archivo físico
            if (!empty($documento['guia'])) {
                $filePath = FCPATH . $documento['guia'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $deleted = $this->documentosModel->delete($id);
            if (!$deleted) {
                throw new \Exception('Error al eliminar el documento de la base de datos');
            }
            
            $this->documentosModel->db->transComplete();
            if ($this->documentosModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }
            
            return redirect()->to('docente/documentos')->with('success', 'Documento eliminado exitosamente');
        } catch (\Exception $e) {
            $this->documentosModel->db->transRollback();
            return redirect()->to('docente/documentos')->with('error', 'Error al eliminar el documento: ' . $e->getMessage());
        }
    }
} 