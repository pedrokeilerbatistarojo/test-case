<?php

namespace App\UseCases\Users;

use App\Libraries\Redis\RedisService;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\Transform\TransformManagerService;
use App\Transformers\Users\UserTransformer;
use Config\Services;
use League\Fractal\Resource\Collection;
use League\Fractal\Manager;
use RedisException;

class ListUsersUseCase
{
    protected UserRepositoryInterface $userRepository;
    protected RedisService $redisService;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->redisService = Services::getRedisServices();
    }

    /**
     * Execute the action list users
     * @return array
     * @throws RedisException
     */
    public function execute(): array
    {
        $usersData = $this->getUserData();

        // Transform the data collection using the transformer
        $transformer = new UserTransformer();
        $resource = new Collection($usersData, $transformer);
        $manager = new Manager();

        return $manager->createData($resource)->toArray();
    }

    /**
     * @throws RedisException
     */
    public function getUserData()
    {
        $usersData = $this->redisService->get('users');

        if (!empty($usersData)){
            return $usersData;
        }

        $usersData = $this->userRepository->findAll();
        $this->redisService->set('users', $usersData);

        return $usersData;
    }
}