<?php

namespace App\UseCases\Users;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Transformers\Users\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class DeleteUserUseCase
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the action delete user
     * @param $userId
     * @return bool
     */
    public function execute($userId): bool
    {
        return $this->userRepository->remove($userId);
    }
}