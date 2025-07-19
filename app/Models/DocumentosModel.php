<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentosModel extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'docente_id',
        'nombre',
        'descripcion',
        'guia',
        'puntaje_asignado',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
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
        'nombre' => 'required|min_length[3]|max_length[255]',
        'descripcion' => 'permit_empty|max_length[1000]',
        'guia' => 'permit_empty|max_length[255]',
        'puntaje_asignado' => 'required|decimal',
        'estado' => 'required|in_list[pendiente,aprobado,rechazado]',
    ];

    protected $validationMessages = [
        'docente_id' => [
            'required' => 'El ID del docente es obligatorio.',
            'integer' => 'El ID del docente debe ser un número entero.',
        ],
        'nombre' => [
            'required' => 'El nombre del documento es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no debe exceder 255 caracteres.',
        ],
        'descripcion' => [
            'max_length' => 'La descripción no debe exceder 1000 caracteres.',
        ],
        'guia' => [
            'max_length' => 'La ruta del archivo no debe exceder 255 caracteres.',
        ],
        'puntaje_asignado' => [
            'required' => 'El puntaje asignado es obligatorio.',
            'decimal' => 'El puntaje debe ser un número decimal.',
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'in_list' => 'El estado debe ser: pendiente, aprobado o rechazado.',
        ],
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
     * Obtiene todos los documentos de un docente específico
     */
    public function getDocumentosByDocente($docenteId)
    {
        return $this->where('docente_id', $docenteId)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Obtiene un documento específico de un docente
     */
    public function getDocumentoByDocente($id, $docenteId)
    {
        return $this->where('id', $id)
                   ->where('docente_id', $docenteId)
                   ->first();
    }

    /**
     * Obtiene documentos por estado
     */
    public function getDocumentosByEstado($docenteId, $estado)
    {
        return $this->where('docente_id', $docenteId)
                   ->where('estado', $estado)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Actualiza el puntaje de un documento
     */
    public function updatePuntaje($id, $puntaje)
    {
        return $this->update($id, [
            'puntaje_asignado' => $puntaje,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Actualiza el estado de un documento
     */
    public function updateEstado($id, $estado)
    {
        return $this->update($id, [
            'estado' => $estado,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
} 