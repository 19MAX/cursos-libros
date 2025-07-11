<?php

namespace App\Models;

use CodeIgniter\Model;

class CapacitacionesModel extends Model
{
    protected $table = 'capacitaciones';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'docente_id',
        'tipo_participacion',
        'nombre_capacitacion',
        'institucion_organizadora',
        'modalidad',
        'duracion_horas',
        'fecha_inicio',
        'fecha_fin',
        'certificado',
        'puntaje_asignado',
        'estado',
        'descripcion',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'docente_id' => 'required|integer',
        'tipo_participacion' => 'required|in_list[asistente,facilitador,organizador,ponente]',
        'nombre_capacitacion' => 'required|min_length[3]|max_length[255]',
        'institucion_organizadora' => 'required|min_length[3]|max_length[255]',
        'modalidad' => 'required|in_list[presencial,virtual,hibrida]',
        'duracion_horas' => 'required|integer|greater_than[0]',
        'fecha_inicio' => 'required|valid_date',
        'fecha_fin' => 'required|valid_date',
        'estado' => 'required|in_list[pendiente,aprobado,rechazado]',
        'descripcion' => 'permit_empty|max_length[1000]'
    ];

    protected $validationMessages = [
        'docente_id' => [
            'required' => 'El ID del docente es requerido',
            'integer' => 'El ID del docente debe ser un número entero'
        ],
        'tipo_participacion' => [
            'required' => 'El tipo de participación es requerido',
            'in_list' => 'El tipo de participación debe ser: asistente, facilitador, organizador o ponente'
        ],
        'nombre_capacitacion' => [
            'required' => 'El nombre de la capacitación es requerido',
            'min_length' => 'El nombre debe tener al menos 3 caracteres',
            'max_length' => 'El nombre no puede exceder 255 caracteres'
        ],
        'institucion_organizadora' => [
            'required' => 'La institución organizadora es requerida',
            'min_length' => 'La institución debe tener al menos 3 caracteres',
            'max_length' => 'La institución no puede exceder 255 caracteres'
        ],
        'modalidad' => [
            'required' => 'La modalidad es requerida',
            'in_list' => 'La modalidad debe ser: presencial, virtual o híbrida'
        ],
        'duracion_horas' => [
            'required' => 'La duración en horas es requerida',
            'integer' => 'La duración debe ser un número entero',
            'greater_than' => 'La duración debe ser mayor a 0'
        ],
        'fecha_inicio' => [
            'required' => 'La fecha de inicio es requerida',
            'valid_date' => 'La fecha de inicio debe ser una fecha válida'
        ],
        'fecha_fin' => [
            'required' => 'La fecha de fin es requerida',
            'valid_date' => 'La fecha de fin debe ser una fecha válida'
        ],
        'estado' => [
            'required' => 'El estado es requerido',
            'in_list' => 'El estado debe ser: pendiente, aprobado o rechazado'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['setCreatedBy'];
    protected $beforeUpdate = ['setUpdatedBy'];
    protected $beforeDelete = ['setDeletedBy'];

    protected function setCreatedBy(array $data)
    {
        if (isset($data['data'])) {
            $data['data']['created_by'] = session()->get('user_id') ?? 1;
        }
        return $data;
    }

    protected function setUpdatedBy(array $data)
    {
        if (isset($data['data'])) {
            $data['data']['updated_by'] = session()->get('user_id') ?? 1;
        }
        return $data;
    }

    protected function setDeletedBy(array $data)
    {
        if (isset($data['data'])) {
            $data['data']['deleted_by'] = session()->get('user_id') ?? 1;
        }
        return $data;
    }

    /**
     * Obtener capacitaciones por docente
     */
    public function getCapacitacionesByDocente($docenteId)
    {
        return $this->where('docente_id', $docenteId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener capacitación específica por ID y docente
     */
    public function getCapacitacionByDocente($id, $docenteId)
    {
        return $this->where('id', $id)
                    ->where('docente_id', $docenteId)
                    ->first();
    }

    /**
     * Obtener estadísticas de capacitaciones por docente
     */
    public function getEstadisticasByDocente($docenteId)
    {
        $total = $this->where('docente_id', $docenteId)->countAllResults();
        $aprobadas = $this->where('docente_id', $docenteId)
                          ->where('estado', 'aprobado')
                          ->countAllResults();
        $pendientes = $this->where('docente_id', $docenteId)
                          ->where('estado', 'pendiente')
                          ->countAllResults();
        $rechazadas = $this->where('docente_id', $docenteId)
                          ->where('estado', 'rechazado')
                          ->countAllResults();

        return [
            'total' => $total,
            'aprobadas' => $aprobadas,
            'pendientes' => $pendientes,
            'rechazadas' => $rechazadas
        ];
    }
} 