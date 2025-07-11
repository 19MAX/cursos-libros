<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTitulosTable extends Migration
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
            'tipo_titulo' => [
                'type' => 'ENUM',
                'constraint' => ['bachiller', 'licenciatura', 'maestria', 'doctorado', 'postdoctorado', 'especialidad', 'diplomado'],
            ],
            'nombre_titulo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'institucion' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pais' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'fecha_obtencion' => [
                'type' => 'DATE',
            ],
            'numero_diploma' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'archivo_diploma' => [
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
        $this->forge->createTable('titulos');
    }

    public function down()
    {
        $this->forge->dropTable('titulos');
    }
}
