<?php

namespace App\Models;

use CodeIgniter\Model;

class LibrosModel extends Model
{
    protected $table            = 'libros';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'docente_id',
        'titulo_libro',
        'subtitulo',
        'autores',
        'editorial',
        'isbn',
        'isbn_electronico',
        'edicion',
        'numero_paginas',
        'fecha_publicacion',
        'pais_publicacion',
        'ciudad_publicacion',
        'tipo_libro',
        'area_conocimiento',
        'disciplina',
        'resumen',
        'palabras_clave',
        'indice',
        'prologo',
        'enlace_editorial',
        'archivo_libro',
        'portada_libro',
        'certificacion_editorial',
        'impacto_academico',
        'citas_referenciadas',
        'puntaje_asignado',
        'estado',
        'observaciones',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
