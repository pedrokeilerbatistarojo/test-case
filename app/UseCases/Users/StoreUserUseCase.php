<?php

namespace App\UseCases\Users;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Transformers\Users\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use ReflectionException;

class StoreUserUseCase
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the action store user
     * @param array $data
     * @return array
     * @throws ReflectionException
     */
    public function execute(array $data): array
    {
        $userData = $this->userRepository->save($data);

        // Transform the data item using the transformer
        $transformer = new UserTransformer();
        $resource = new Item($userData, $transformer);
        $manager = new Manager();

        return $manager->createData($resource)->toArray();
    }
}