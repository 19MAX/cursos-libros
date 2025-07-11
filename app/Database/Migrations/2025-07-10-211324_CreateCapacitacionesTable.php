<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCapacitacionesTable extends Migration
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
            'tipo_participacion' => [
                'type' => 'ENUM',
                'constraint' => ['asistente', 'facilitador', 'organizador', 'ponente'],
            ],
            'nombre_capacitacion' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'institucion_organizadora' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'modalidad' => [
                'type' => 'ENUM',
                'constraint' => ['presencial', 'virtual', 'hibrida'],
            ],
            'duracion_horas' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'fecha_inicio' => [
                'type' => 'DATE',
            ],
            'fecha_fin' => [
                'type' => 'DATE',
            ],
            'certificado' => [
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
        $this->forge->createTable('capacitaciones');
    }

    public function down()
    {
        $this->forge->dropTable('capacitaciones');
    }
}
