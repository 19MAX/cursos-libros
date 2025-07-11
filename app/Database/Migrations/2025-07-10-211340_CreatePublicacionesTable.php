<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublicacionesTable extends Migration
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
            'tipo_publicacion' => [
                'type' => 'ENUM',
                'constraint' => ['articulo_revista', 'libro', 'capitulo_libro', 'tesis', 'ponencia', 'resumen', 'otros'],
            ],
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'autores' => [
                'type' => 'TEXT',
            ],
            'revista_editorial' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
            'issn_isbn' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'doi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'fecha_publicacion' => [
                'type' => 'DATE',
            ],
            'indexacion' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Scopus, Web of Science, etc.',
            ],
            'cuartil' => [
                'type' => 'ENUM',
                'constraint' => ['Q1', 'Q2', 'Q3', 'Q4'],
                'null' => true,
            ],
            'enlace_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'archivo_publicacion' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
            'descripcion' => [
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
        $this->forge->addForeignKey('docente_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('publicaciones');
    }

    public function down()
    {
        $this->forge->dropTable('publicaciones');
    }
}
