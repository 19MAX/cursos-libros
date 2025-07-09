<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = false;
    protected $allowedFields = [];

    // Validation rules
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[8]'
    ];

    public function findUserByEmail(string $email)
    {
        return $this->where('email', $email)
            ->where('deleted_at IS NULL')
            ->first();
    }

    public function findUserByVerificationCode(string $code)
    {
        return $this->where('verification_code', $code)
            ->where('deleted_at IS NULL')
            ->first();
    }

    public function findUserByCI($ci)
    {
        return $this->where('ci', $ci)->first();
    }

}
