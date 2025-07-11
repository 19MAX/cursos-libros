<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEvaluacionesTable extends Migration
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
            'evaluador_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tipo_item' => [
                'type' => 'ENUM',
                'constraint' => ['titulo', 'capacitacion', 'publicacion', 'experiencia', 'proyecto'],
            ],
            'item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'puntaje_anterior' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'puntaje_nuevo' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'justificacion' => [
                'type' => 'TEXT',
            ],
            'fecha_evaluacion' => [
                'type' => 'DATETIME',
                'null' => false,
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
        $this->forge->addKey('evaluador_id');
        $this->forge->addForeignKey('docente_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('evaluador_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('evaluaciones');
    }

    public function down()
    {
        $this->forge->dropTable('evaluaciones');
    }
}
