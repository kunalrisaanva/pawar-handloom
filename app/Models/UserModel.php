<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = TBL_USER;
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role',
        'name',
        'company_name',
        'email',
        'phone',
        'whatsapp_no',
        'address',
        'password',
        'status',
        'is_deleted',
        'created_at',
        'updated_at',
        'reset_token',       
        'token_expiry',

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
    //protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'company_name' => 'required',
        'email'        => 'required|valid_email|is_unique[' . TBL_USER . '.email]',
        'phone'        => 'required|numeric',
        'whatsapp_no'  => 'required|numeric',
        'address'      => 'required',
        'password'     => 'required|min_length[6]',
    ];
    protected $validationMessages   = [
        'company_name' => [
            'required' => 'The Company Name field is required.',
        ],
        'email' => [
            'required'    => 'The Email Address field is required.',
            'valid_email' => 'Please enter a valid Email Address.',
            'is_unique'   => 'This Email Address is already registered.',
        ],
        'phone' => [
            'required' => 'The Phone field is required.',
            'numeric'  => 'The Phone field must be a number.',
        ],
        'whatsapp_no' => [
            'required' => 'The WhatsApp Number field is required.',
            'numeric'  => 'The WhatsApp Number must be a number.',
        ],
        'address' => [
            'required' => 'The Address field is required.',
        ],
        'password' => [
            'required'   => 'The Password field is required.',
            'min_length' => 'The Password must be at least 6 characters long.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    // Automatically hash password before saving
    protected function hashPassword(array $data)
    {
        if (!empty($data['data']['password'])) {
            $data['data']['password'] = hash('sha256', trim($data['data']['password']));
        }
        return $data;
    }

}
