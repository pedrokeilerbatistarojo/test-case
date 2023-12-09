<?php

namespace App\UseCases\Users;

use App\Libraries\Redis\RedisService;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Transformers\Users\UserTransformer;
use Config\Services;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use RedisException;

class DeleteUserUseCase
{
    protected UserRepositoryInterface $userRepository;
    private RedisService $redisService;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->redisService = Services::getRedisServices();
    }

    /**
     * Execute the action delete user
     * @param $userId
     * @return bool
     * @throws RedisException
     */
    public function execute($userId): bool
    {
        $result = $this->userRepository->remove($userId);

        $usersData = $this->userRepository->findAll();
        $this->redisService->set('users', $usersData);

        return $result;
    }
}