<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\Criteria\Users\FieldUserCriteria;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {

    }

    /**
     * Login users with api
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function login()
    {

        $data = [
            'status'  => 'success',
            'message' => 'Login successful',
        ];

        return $this->respond($data);
    }
}
