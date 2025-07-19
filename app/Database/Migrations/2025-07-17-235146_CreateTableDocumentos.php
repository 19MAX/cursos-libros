<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDocumentos extends Migration
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
                'null' => false,
                'comment' => 'ID del docente propietario',
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment' => 'Nombre del documento',
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Descripción del documento',
            ],
            'guia' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Ruta del archivo PDF de la guía',
            ],
            'puntaje_asignado' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
                'null' => false,
                'comment' => 'Puntaje asignado al documento',
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['pendiente', 'aprobado', 'rechazado'],
                'default' => 'pendiente',
                'null' => false,
                'comment' => 'Estado del documento',
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
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'deleted_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('docente_id');
        $this->forge->addKey('estado');

        $this->forge->createTable('documentos');
    }

    public function down()
    {
        $this->forge->dropTable('documentos');
    }
}
