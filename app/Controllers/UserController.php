<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Users\ListUsersUseCase;
use App\UseCases\Users\StoreUserUseCase;
use App\Validation\Users\StoreUserValidation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use ReflectionException;

class UserController extends BaseController
{
    use ResponseTrait;
    private ListUsersUseCase $listUsersUseCase;
    private StoreUserUseCase $storeUserUseCase;

    public function __construct()
    {
        $this->listUsersUseCase = Services::getListUsersUseCase();
        $this->storeUserUseCase = Services::getStoreUserUseCase();
    }

    /**
     * List users
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $response = $this->listUsersUseCase->execute();
        return $this->respond($response);
    }

    /**
     * Store user
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function store(): ResponseInterface
    {
        $validation = Services::validation();
        $validation->setRules(StoreUserValidation::rules(), StoreUserValidation::messages());
        if ($validation->withRequest($this->request)->run()) {
            $data = $this->request->getPost();

            //Execute Login Use Case
            $user = $this->storeUserUseCase->execute($data);

            if ($user) {
                $data['message'] = 'User created successful';
                return $this->respond($data, 201);
            } else {
                return $this->failUnauthorized('Invalid create user request');
            }
        }

        return $this->failValidationErrors($validation->getErrors());
    }


    /**
     * Store user
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function update(): ResponseInterface
    {
        $validation = Services::validation();
        $validation->setRules(StoreUserValidation::rules(), StoreUserValidation::messages());
        if ($validation->withRequest($this->request)->run()) {
            $data = $this->request->getPost();

            //Execute Login Use Case
            $user = $this->storeUserUseCase->execute($data);

            if ($user) {
                $data['message'] = 'User updated successful';
                return $this->respond($data, 201);
            } else {
                return $this->failUnauthorized('Invalid updated user request');
            }
        }

        return $this->failValidationErrors($validation->getErrors());
    }
}
