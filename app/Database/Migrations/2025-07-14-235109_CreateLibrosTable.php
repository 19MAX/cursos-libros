<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLibrosTable extends Migration
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
            'titulo_libro' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => false,
            ],
            'subtitulo' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'autores' => [
                'type' => 'TEXT',
                'null' => false,
                'comment' => 'Lista de autores del libro',
            ],
            'editorial' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'isbn' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'isbn_electronico' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'edicion' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'numero_paginas' => [
                'type' => 'INT',
                'constraint' => 11,
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
            'ciudad_publicacion' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'tipo_libro' => [
                'type' => 'ENUM',
                'constraint' => ['libro_completo', 'capitulo_libro', 'libro_texto', 'libro_cientifico', 'libro_tecnico', 'otros'],
                'default' => 'libro_completo',
            ],
            'area_conocimiento' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'disciplina' => [
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
            'indice' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Índice del libro',
            ],
            'prologo' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'enlace_editorial' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'archivo_libro' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Archivo PDF o digital del libro',
            ],
            'portada_libro' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Imagen de la portada del libro',
            ],
            'certificacion_editorial' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Certificación de la editorial',
            ],
            'impacto_academico' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Descripción del impacto académico del libro',
            ],
            'citas_referenciadas' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Número de citas del libro',
            ],
            'puntaje_asignado' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['pendiente', 'aprobado', 'rechazado'],
                'default' => 'pendiente',
            ],
            'observaciones' => [
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
        $this->forge->addKey('isbn');
        $this->forge->addForeignKey('docente_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('libros');
    }

    public function down()
    {
        $this->forge->dropTable('libros');
    }
}
