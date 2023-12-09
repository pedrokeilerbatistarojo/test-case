<?php

namespace App\Controllers;

use App\UseCases\Auth\LoginUseCase;
use App\Validation\Auth\LoginValidation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use ReflectionException;

class AuthController extends BaseController
{
    use ResponseTrait;

    private LoginUseCase $loginUseCase;

    public function __construct()
    {
        $this->loginUseCase = Services::getLoginUseCase();
    }

    /**
     * Login users with api
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function login(): ResponseInterface
    {
        $validation = Services::validation();
        $validation->setRules(LoginValidation::rules(), LoginValidation::messages());

        //Running validation rules
        if ($validation->withRequest($this->request)->run()) {
            $phone    = $this->request->getPost('phone');
            $password = $this->request->getPost('password');

            //Execute Login Use Case
            $token = $this->loginUseCase->execute($phone, $password);

            if ($token) {
                $data['message'] = 'Login successful';
                $data['token'] = $token;
                return $this->respond($data);
            } else {
                return $this->failUnauthorized('Invalid credentials');
            }
        }

        return $this->failValidationErrors($validation->getErrors());
    }
}
