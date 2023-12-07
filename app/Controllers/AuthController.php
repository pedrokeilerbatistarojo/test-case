<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

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
