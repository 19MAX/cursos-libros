<?php

namespace App\Controllers\Docente;

use App\Controllers\BaseController;
use App\Models\CapacitacionesModel;
use CodeIgniter\HTTP\ResponseInterface;

class CapacitacionesController extends BaseController
{
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

        // Si no hay capacitaciones, mostrar datos de ejemplo
        if (empty($capacitaciones)) {
            $capacitaciones = [
                [
                    'id' => 1,
                    'nombre_capacitacion' => 'Programación Web Avanzada',
                    'institucion_organizadora' => 'Universidad Nacional',
                    'fecha_inicio' => '2024-01-15',
                    'fecha_fin' => '2024-03-15',
                    'duracion_horas' => 40,
                    'puntaje_asignado' => 8.5,
                    'estado' => 'aprobado',
                    'tipo_participacion' => 'asistente',
                    'modalidad' => 'virtual'
                ],
                [
                    'id' => 2,
                    'nombre_capacitacion' => 'Diseño UX/UI',
                    'institucion_organizadora' => 'Instituto Tecnológico',
                    'fecha_inicio' => '2024-02-01',
                    'fecha_fin' => '2024-04-01',
                    'duracion_horas' => 60,
                    'puntaje_asignado' => 9.0,
                    'estado' => 'pendiente',
                    'tipo_participacion' => 'facilitador',
                    'modalidad' => 'presencial'
                ],
                [
                    'id' => 3,
                    'nombre_capacitacion' => 'Gestión de Proyectos',
                    'institucion_organizadora' => 'Centro de Capacitación',
                    'fecha_inicio' => '2024-03-10',
                    'fecha_fin' => '2024-05-10',
                    'duracion_horas' => 80,
                    'puntaje_asignado' => 7.5,
                    'estado' => 'aprobado',
                    'tipo_participacion' => 'ponente',
                    'modalidad' => 'hibrida'
                ]
            ];
        }

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

    public function store()
    {
        // Instanciar el modelo
        $capacitacionesModel = new CapacitacionesModel();

        // Obtener datos del formulario
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
            'puntaje_asignado' => 0.00
        ];

        // Validar y guardar
        if ($capacitacionesModel->insert($data)) {
            return redirect()->to('docente/capacitaciones')->with('success', 'Capacitación creada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $capacitacionesModel->errors());
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

        // Obtener datos del formulario
        $data = [
            'nombre_capacitacion' => $this->request->getPost('nombre_capacitacion'),
            'institucion_organizadora' => $this->request->getPost('institucion_organizadora'),
            'modalidad' => $this->request->getPost('modalidad'),
            'duracion_horas' => $this->request->getPost('duracion_horas'),
            'fecha_inicio' => $this->request->getPost('fecha_inicio'),
            'fecha_fin' => $this->request->getPost('fecha_fin'),
            'tipo_participacion' => $this->request->getPost('tipo_participacion'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        // Validar y actualizar
        if ($capacitacionesModel->update($id, $data)) {
            return redirect()->to('docente/capacitaciones')->with('success', 'Capacitación actualizada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $capacitacionesModel->errors());
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

        // Eliminar la capacitación
        if ($capacitacionesModel->delete($id)) {
            return redirect()->to('docente/capacitaciones')->with('success', 'Capacitación eliminada exitosamente');
        } else {
            return redirect()->to('docente/capacitaciones')->with('error', 'Error al eliminar la capacitación');
        }
    }
}