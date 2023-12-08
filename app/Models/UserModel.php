<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    const TYPE_ADMIN = 'admin';
    CONST TYPE_BASIC = 'basic';

    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name',
        'last_name',
        'picture',
        'phone',
        'email',
        'password',
        'type',
        'created_at',
        'updated_at',
        'last_login',
        'deleted_at',
    ];

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
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['creating'];
    protected $beforeUpdate   = ['updating'];

    protected function creating(array $data): array
    {
        return $this->transformStringToHashed($data);
    }
    protected function updating(array $data): array
    {
        return $this->transformStringToHashed($data);
    }

    private function transformStringToHashed(array $data) : array {
        if (isset($data['data']['password'])){
            $planText = $data['data']['password'];
            $data['data']['password'] = password_hash($planText, PASSWORD_BCRYPT);
        }

        return $data;
    }
}
