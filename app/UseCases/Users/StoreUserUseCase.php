<?php

namespace App\UseCases\Users;

use App\Libraries\Redis\RedisService;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Transformers\Users\UserTransformer;
use Config\Services;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use RedisException;
use ReflectionException;

class StoreUserUseCase
{
    protected UserRepositoryInterface $userRepository;
    private RedisService $redisService;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->redisService = Services::getRedisServices();
    }

    /**
     * Execute the action store user
     * @param array $data
     * @return array
     * @throws ReflectionException|RedisException
     */
    public function execute(array $data): array
    {
        $userData = $this->userRepository->save($data);

        $usersData = $this->userRepository->findAll();
        $this->redisService->set('users', $usersData);

        // Transform the data item using the transformer
        $transformer = new UserTransformer();
        $resource = new Item($userData, $transformer);
        $manager = new Manager();

        return $manager->createData($resource)->toArray();
    }
}