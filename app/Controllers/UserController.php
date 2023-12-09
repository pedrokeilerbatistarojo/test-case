<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Services\Users\UploadUserPictureService;
use App\UseCases\Users\ListUsersUseCase;
use App\UseCases\Users\StoreUserUseCase;
use App\Validation\Users\StoreUserValidation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;
use RedisException;
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
        helper('auth/access_role');
    }

    /**
     * List users
     * @return ResponseInterface
     * @throws RedisException
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
        if ($this->validationByTokenRole($this->request->getHeaderLine('Authorization'), UserModel::TYPE_ADMIN)){
            return $this->failUnauthorized('The user is not authorized for this action');
        }

        $validation = Services::validation();
        $validation->setRules(StoreUserValidation::rules([]), StoreUserValidation::messages());
        if ($validation->withRequest($this->request)->run()) {
            $data = $this->request->getPost();

            //Upload a picture service handle
            $data['picture'] = UploadUserPictureService::handle($this->request);

            //Execute Store Use Case
            $user = $this->storeUserUseCase->execute($data);

            if ($user) {
                return $this->respond($user, ResponseInterface::HTTP_CREATED);
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
        $data = $this->request->getJSON(true);
        $tokenData = getDataTokenByAuthorizationHeader($this->request->getHeaderLine('Authorization'));
        if (!StoreUserValidation::validActionUserBasic($tokenData, $data)){
            return $this->failUnauthorized('The user is not authorized for this action');
        }

        $validation = Services::validation();
        $validation->setRules(StoreUserValidation::rules($data, true), StoreUserValidation::messages());
        if ($validation->withRequest($this->request)->run()) {
            //Upload a picture service handle
            $data['picture'] = UploadUserPictureService::handleBase64($data);

            //Execute Update Use Case
            $user = $this->storeUserUseCase->execute($data);

            if ($user) {
                return $this->respond($user, ResponseInterface::HTTP_OK);
            } else {
                return $this->failUnauthorized('Invalid updated user request');
            }
        }

        return $this->failValidationErrors($validation->getErrors());
    }

    /**
     * Delete user
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        if ($this->validationByTokenRole($this->request->getHeaderLine('Authorization'), UserModel::TYPE_ADMIN)){
            return $this->failUnauthorized('The user is not authorized for this action');
        }

        $validation = Services::validation();
        $validation->setRules(['id' => 'required']);
        if ($validation->withRequest($this->request)->run()) {
            $data = $this->request->getJSON(true);

            $deleteUserCase = Services::getDeleteUserUseCase();
            $result = $deleteUserCase->execute($data['id']);

            if ($result) {
                return $this->respond([
                    'message' => 'Delete Successfully Success'
                ], ResponseInterface::HTTP_OK);
            } else {
                return $this->failUnauthorized('Invalid deleted user request');
            }
        }

        return $this->failValidationErrors($validation->getErrors());
    }

    /**
     * Download list users in PDF
     * @return ResponseInterface
     * @throws Exception
     */
    public function downloadPdf(): ResponseInterface
    {
        $downloadUserUseCase = Services::getDownloadUserUseCase();
        $pdfUrl = $downloadUserUseCase->execute();

        return $this->respond([
            'pdf_url' => $pdfUrl
        ], ResponseInterface::HTTP_OK);
    }

    /**
     * Validation by token role
     * @param $authHeader
     * @param $userRole
     * @return bool
     */
    private function validationByTokenRole($authHeader, $userRole): bool
    {
        $tokenData = getDataTokenByAuthorizationHeader($authHeader);

        if ($tokenData->type != $userRole){
            return true;
        }

        return false;
    }

    /**
     * @throws RedisException
     */
    public function pdf()
    {
        $data = ['users' => $this->listUsersUseCase->getUserData()];

        return view('users/pdf', $data);
    }

}
