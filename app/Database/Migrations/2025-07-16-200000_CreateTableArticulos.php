<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableArticulos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'docente_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'titulo_articulo' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => false,
            ],
            'autores' => [
                'type' => 'TEXT',
                'null' => false,
                'comment' => 'Lista de autores del artículo',
            ],
            'revista' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'issn' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'volumen' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'paginas' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'fecha_publicacion' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'pais_publicacion' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'tipo_revision' => [
                'type' => 'ENUM',
                'constraint' => [
                    'Revisión doble ciego (Double-blind review)',
                    'Revisión simple ciego (Single-blind review)',
                    'Revisión abierta (Open review)',
                    'Revisión colaborativa (Collaborative review)',
                    'Revisión por la comunidad o post-publicación (Public/Community review)',
                    'Revisión editorial (Editorial review)'
                ],
                'null' => false,
                'comment' => 'Tipo de revisión del artículo',
            ],
            'tipo_articulo' => [
                'type' => 'ENUM',
                'constraint' => [
                    'Artículo de investigación',
                    'Artículo de revisión',
                    'Preprint',
                    'Artículo técnico',
                    'Artículo de opinión / ensayo',
                    'Estudio de caso',
                    'Meta-análisis'
                ],
                'null' => false,
                'comment' => 'Tipo de artículo',
            ],
            'cuartil' => [
                'type' => 'ENUM',
                'constraint' => ['Q1', 'Q2', 'Q3', 'Q4'],
                'default' => 'Q1',
                'null' => false,
                'comment' => 'Cuartil de la revista',
            ],
            'doi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'DOI del artículo',
            ],
            // CAMPOS NUEVOS SEGÚN FORMULARIO
            'campo_amplio' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'campo_especifico' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'campo_detallado' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'resumen' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'palabras_clave' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Palabras clave separadas por comas',
            ],
            'enlace_revista' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'archivo_articulo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Archivo PDF o digital del artículo',
            ],
            'portada_articulo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Imagen del Certificado de publicación / Aceptación',
            ],
            'factor_impacto' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'comment' => 'Factor de impacto numérico',
            ],
            'puntaje_asignado' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
                'null' => false,
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['pendiente', 'aprobado', 'rechazado'],
                'default' => 'pendiente',
            ],
            'descripcion_articulo' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
                'default' => 1,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'deleted_by' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('docente_id');
        $this->forge->addKey('issn');
        $this->forge->addForeignKey('docente_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('articulos');
    }

    public function down()
    {
        $this->forge->dropTable('articulos');
    }
}
