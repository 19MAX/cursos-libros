<?php

namespace App\Controllers\Docente;

use App\Controllers\BaseController;
use App\Models\CapacitacionesModel;
use CodeIgniter\HTTP\ResponseInterface;

class CapacitacionesController extends BaseController
{


    protected $capacitacionesModel;
    protected $validation;

    public function __construct()
    {
        $this->capacitacionesModel = new CapacitacionesModel();
        $this->validation = \Config\Services::validation();
        helper('files');
    }

    public function index()
    {
        // Obtener el ID del docente desde la sesión
        $docenteId = session()->get('user_id');

        // Debug temporal - si no hay user_id, usar un ID por defecto
        if (!$docenteId) {
            $docenteId = 1; // ID por defecto para pruebas
        }

        // Instanciar el modelo
        $capacitacionesModel = new CapacitacionesModel();

        // Obtener las capacitaciones del docente
        $capacitaciones = $capacitacionesModel->getCapacitacionesByDocente($docenteId);


        // Obtener estadísticas
        $estadisticas = $capacitacionesModel->getEstadisticasByDocente($docenteId);

        // Si no hay estadísticas, calcular con datos de ejemplo
        if (empty($estadisticas['total'])) {
            $estadisticas = [
                'total' => count($capacitaciones),
                'aprobadas' => count(array_filter($capacitaciones, fn($c) => $c['estado'] === 'aprobado')),
                'pendientes' => count(array_filter($capacitaciones, fn($c) => $c['estado'] === 'pendiente')),
                'rechazadas' => count(array_filter($capacitaciones, fn($c) => $c['estado'] === 'rechazado'))
            ];
        }

        return view("docente/capacitaciones/index", [
            'capacitaciones' => $capacitaciones,
            'estadisticas' => $estadisticas
        ]);
    }

    public function create()
    {
        return view("docente/capacitaciones/create");
    }

    private function processFile($file, $capacitacionNombre)
    {
        $docenteId = session()->get('user_id');

        // Debug: Verificar datos del archivo
        log_message('debug', 'Processing file - Docente ID: ' . $docenteId);
        log_message('debug', 'File name: ' . $file->getName());
        log_message('debug', 'File size: ' . $file->getSize());
        log_message('debug', 'File extension: ' . $file->getClientExtension());
        log_message('debug', 'Capacitacion nombre: ' . $capacitacionNombre);

        $result = uploadCapacitacionFile($file, $docenteId, $capacitacionNombre);

        // Debug: Verificar resultado
        log_message('debug', 'Upload result: ' . json_encode($result));

        return $result;
    }

    public function store()
    {
        // Validar datos del formulario
        $validationRules = [
            'nombre_capacitacion' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'El nombre de la capacitación es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                    'max_length' => 'El nombre no debe exceder 255 caracteres.'
                ]
            ],
            'institucion_organizadora' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'La institución organizadora es obligatoria.',
                    'min_length' => 'La institución debe tener al menos 3 caracteres.',
                    'max_length' => 'La institución no debe exceder 255 caracteres.'
                ]
            ],
            'modalidad' => [
                'rules' => 'required|in_list[presencial,virtual,hibrida]',
                'errors' => [
                    'required' => 'La modalidad es obligatoria.',
                    'in_list' => 'La modalidad debe ser: presencial, virtual o híbrida.'
                ]
            ],
            'duracion_horas' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'La duración en horas es obligatoria.',
                    'integer' => 'La duración debe ser un número entero.',
                    'greater_than' => 'La duración debe ser mayor a 0.'
                ]
            ],
            'fecha_inicio' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de inicio es obligatoria.',
                    'valid_date' => 'La fecha de inicio no es válida.'
                ]
            ],
            'fecha_fin' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de fin es obligatoria.',
                    'valid_date' => 'La fecha de fin no es válida.'
                ]
            ],
            'tipo_participacion' => [
                'rules' => 'required|in_list[asistente,facilitador,organizador,ponente]',
                'errors' => [
                    'required' => 'El tipo de participación es obligatorio.',
                    'in_list' => 'El tipo de participación debe ser: asistente, facilitador, organizador o ponente.'
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|max_size[file,10240]',
                'errors' => [
                    'uploaded' => 'Debe subir un archivo de certificado.',
                    'max_size' => 'El archivo no debe exceder 10MB.'
                ]
            ]

        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validation->getErrors());
        }

        // Preparar datos básicos
        $data = [
            'docente_id' => session()->get('user_id'),
            'nombre_capacitacion' => $this->request->getPost('nombre_capacitacion'),
            'institucion_organizadora' => $this->request->getPost('institucion_organizadora'),
            'modalidad' => $this->request->getPost('modalidad'),
            'duracion_horas' => $this->request->getPost('duracion_horas'),
            'fecha_inicio' => $this->request->getPost('fecha_inicio'),
            'fecha_fin' => $this->request->getPost('fecha_fin'),
            'tipo_participacion' => $this->request->getPost('tipo_participacion'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => 'pendiente',
            'puntaje_asignado' => 0.00,
            'created_by' => session()->get('user_id')
        ];

        // Validar fechas
        if (strtotime($data['fecha_inicio']) > strtotime($data['fecha_fin'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La fecha de inicio no puede ser posterior a la fecha de fin.');
        }

        // Procesar archivo obligatorio
        $file = $this->request->getFile('file');

        // Verificar que el archivo fue realmente subido
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Debe subir un certificado válido para la capacitación.');
        }

        // Validar archivo con el helper
        $validation = validateCapacitacionFile($file);
        if (!$validation['valid']) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(', ', $validation['errors']));
        }

        // Procesar archivo
        $fileResult = $this->processFile($file, $data['nombre_capacitacion']);

        if (!$fileResult['success']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $fileResult['message']);
        }

        // Asignar ruta del certificado - ESTO ES CRUCIAL
        $data['certificado'] = $fileResult['path'];

        // Verificar que la ruta del certificado no esté vacía
        if (empty($data['certificado'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al procesar el certificado. Intente nuevamente.');
        }

        // Usar transacción de base de datos
        $this->capacitacionesModel->db->transStart();

        try {
            // Insertar capacitación
            $capacitacionId = $this->capacitacionesModel->insert($data);

            if (!$capacitacionId) {
                throw new \Exception('Error al crear la capacitación en la base de datos');
            }

            // Verificar que se insertó correctamente
            $insertedCapacitacion = $this->capacitacionesModel->find($capacitacionId);
            if (!$insertedCapacitacion || empty($insertedCapacitacion['certificado'])) {
                throw new \Exception('Error: La ruta del certificado no se guardó correctamente');
            }

            $this->capacitacionesModel->db->transComplete();

            if ($this->capacitacionesModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }

            return redirect()->to('docente/capacitaciones')
                ->with('success', 'Capacitación creada exitosamente');

        } catch (\Exception $e) {
            $this->capacitacionesModel->db->transRollback();

            // Eliminar archivo subido si hubo error
            if (isset($data['certificado'])) {
                deleteCapacitacionFile($data['certificado']);
            }

            log_message('error', 'Error creating capacitacion: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error interno del servidor: ' . $e->getMessage());
        }
    }

    /**
     * Método para eliminar un docente y todos sus archivos asociados.
     * Llamar este método cuando elimines un docente.
     */
    public function deleteDocente($docenteId)
    {
        try {
            // Eliminar todos los archivos del docente
            deleteDocenteCapacitacionesFolder($docenteId);

            // Aquí puedes agregar la lógica para eliminar el docente de la base de datos
            // $this->docenteModel->delete($docenteId);

            return redirect()->to('admin/docentes')
                ->with('success', 'Docente eliminado exitosamente');

        } catch (\Exception $e) {
            log_message('error', 'Error deleting docente: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al eliminar el docente');
        }
    }

    public function edit($id)
    {
        // Instanciar el modelo
        $capacitacionesModel = new CapacitacionesModel();

        // Obtener la capacitación específica
        $capacitacion = $capacitacionesModel->getCapacitacionByDocente($id, session()->get('user_id'));

        if (!$capacitacion) {
            return redirect()->to('docente/capacitaciones')->with('error', 'Capacitación no encontrada');
        }

        // Verificar que la capacitación esté en estado pendiente
        if ($capacitacion['estado'] !== 'pendiente') {
            return redirect()->to('docente/capacitaciones')->with('error', 'Solo se pueden editar capacitaciones con estado pendiente');
        }

        return view("docente/capacitaciones/edit", [
            'capacitacion' => $capacitacion
        ]);
    }

    public function update($id)
    {
        // Instanciar el modelo
        $capacitacionesModel = new CapacitacionesModel();

        // Verificar que la capacitación pertenece al docente
        $capacitacion = $capacitacionesModel->getCapacitacionByDocente($id, session()->get('user_id'));

        if (!$capacitacion) {
            return redirect()->to('docente/capacitaciones')->with('error', 'Capacitación no encontrada');
        }

        // Verificar que la capacitación esté en estado pendiente
        if ($capacitacion['estado'] !== 'pendiente') {
            return redirect()->to('docente/capacitaciones')->with('error', 'Solo se pueden editar capacitaciones con estado pendiente');
        }

        // Validar datos del formulario
        $validationRules = [
            'nombre_capacitacion' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'El nombre de la capacitación es obligatorio.',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                    'max_length' => 'El nombre no debe exceder 255 caracteres.'
                ]
            ],
            'institucion_organizadora' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'La institución organizadora es obligatoria.',
                    'min_length' => 'La institución debe tener al menos 3 caracteres.',
                    'max_length' => 'La institución no debe exceder 255 caracteres.'
                ]
            ],
            'modalidad' => [
                'rules' => 'required|in_list[presencial,virtual,hibrida]',
                'errors' => [
                    'required' => 'La modalidad es obligatoria.',
                    'in_list' => 'La modalidad debe ser: presencial, virtual o híbrida.'
                ]
            ],
            'duracion_horas' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'La duración en horas es obligatoria.',
                    'integer' => 'La duración debe ser un número entero.',
                    'greater_than' => 'La duración debe ser mayor a 0.'
                ]
            ],
            'fecha_inicio' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de inicio es obligatoria.',
                    'valid_date' => 'La fecha de inicio no es válida.'
                ]
            ],
            'fecha_fin' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha de fin es obligatoria.',
                    'valid_date' => 'La fecha de fin no es válida.'
                ]
            ],
            'tipo_participacion' => [
                'rules' => 'required|in_list[asistente,facilitador,organizador,ponente]',
                'errors' => [
                    'required' => 'El tipo de participación es obligatorio.',
                    'in_list' => 'El tipo de participación debe ser: asistente, facilitador, organizador o ponente.'
                ]
            ]
        ];

        // Si se subió un nuevo archivo, agregar validación
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $validationRules['file'] = [
                'rules' => 'max_size[file,10240]',
                'errors' => [
                    'max_size' => 'El archivo no debe exceder 10MB.'
                ]
            ];
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validation->getErrors());
        }

        // Preparar datos básicos
        $data = [
            'nombre_capacitacion' => $this->request->getPost('nombre_capacitacion'),
            'institucion_organizadora' => $this->request->getPost('institucion_organizadora'),
            'modalidad' => $this->request->getPost('modalidad'),
            'duracion_horas' => $this->request->getPost('duracion_horas'),
            'fecha_inicio' => $this->request->getPost('fecha_inicio'),
            'fecha_fin' => $this->request->getPost('fecha_fin'),
            'tipo_participacion' => $this->request->getPost('tipo_participacion'),
            'descripcion' => $this->request->getPost('descripcion'),
            'updated_by' => session()->get('user_id')
        ];

        // Validar fechas
        if (strtotime($data['fecha_inicio']) > strtotime($data['fecha_fin'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La fecha de inicio no puede ser posterior a la fecha de fin.');
        }

        // Procesar archivo si se subió uno nuevo
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validar archivo con el helper
            $validation = validateCapacitacionFile($file);
            if (!$validation['valid']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', implode(', ', $validation['errors']));
            }

            // Procesar archivo
            $fileResult = $this->processFile($file, $data['nombre_capacitacion']);

            if (!$fileResult['success']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', $fileResult['message']);
            }

            // Eliminar archivo anterior si existe
            if (!empty($capacitacion['certificado'])) {
                deleteCapacitacionFile($capacitacion['certificado']);
            }

            // Asignar nueva ruta del certificado
            $data['certificado'] = $fileResult['path'];
        }

        // Usar transacción de base de datos
        $this->capacitacionesModel->db->transStart();

        try {
            // Actualizar capacitación
            $updated = $this->capacitacionesModel->update($id, $data);

            if (!$updated) {
                throw new \Exception('Error al actualizar la capacitación en la base de datos');
            }

            $this->capacitacionesModel->db->transComplete();

            if ($this->capacitacionesModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }

            return redirect()->to('docente/capacitaciones')
                ->with('success', 'Capacitación actualizada exitosamente');

        } catch (\Exception $e) {
            $this->capacitacionesModel->db->transRollback();

            // Eliminar archivo subido si hubo error
            if (isset($data['certificado']) && isset($fileResult)) {
                deleteCapacitacionFile($data['certificado']);
            }

            log_message('error', 'Error updating capacitacion: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error interno del servidor: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Instanciar el modelo
        $capacitacionesModel = new CapacitacionesModel();

        // Verificar que la capacitación pertenece al docente
        $capacitacion = $capacitacionesModel->getCapacitacionByDocente($id, session()->get('user_id'));

        if (!$capacitacion) {
            return redirect()->to('docente/capacitaciones')->with('error', 'Capacitación no encontrada');
        }

        // Verificar que la capacitación esté en estado pendiente
        if ($capacitacion['estado'] !== 'pendiente') {
            return redirect()->to('docente/capacitaciones')->with('error', 'Solo se pueden eliminar capacitaciones con estado pendiente');
        }

        // Usar transacción de base de datos
        $this->capacitacionesModel->db->transStart();

        try {
            // Eliminar archivo asociado si existe
            if (!empty($capacitacion['certificado'])) {
                deleteCapacitacionFile($capacitacion['certificado']);
        }

        // Eliminar la capacitación
            $deleted = $this->capacitacionesModel->delete($id);

            if (!$deleted) {
                throw new \Exception('Error al eliminar la capacitación de la base de datos');
            }

            $this->capacitacionesModel->db->transComplete();

            if ($this->capacitacionesModel->db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos');
            }

            return redirect()->to('docente/capacitaciones')->with('success', 'Capacitación eliminada exitosamente');

        } catch (\Exception $e) {
            $this->capacitacionesModel->db->transRollback();
            log_message('error', 'Error deleting capacitacion: ' . $e->getMessage());

            return redirect()->to('docente/capacitaciones')->with('error', 'Error al eliminar la capacitación: ' . $e->getMessage());
        }
    }

}