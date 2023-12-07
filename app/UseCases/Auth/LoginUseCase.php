<?php
namespace App\UseCases\Auth;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\Criteria\Users\FieldUserCriteria;

class LoginUseCase
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $phone, string $password)
    {
        $criteriaPhone = new FieldUserCriteria('phone', $phone);

        $users = $this->userRepository->search($criteriaPhone);

        // Process login information
        if (!empty($users)) {
            echo "Usuario encontrado.\n";
        } else {
            echo "Usuario no encontrado.\n";
        }

//        if (!$users || !password_verify($contrasena, $usuario['contrasena'])) {
//            return null;
//        }

        return $users;
    }
}