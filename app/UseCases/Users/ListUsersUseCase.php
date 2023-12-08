<?php

namespace App\UseCases\Users;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\Transform\TransformManagerService;
use App\Transformers\Users\UserTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Manager;

class ListUsersUseCase
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the action list users
     * @return array
     */
    public function execute(): array
    {
        $userData = $this->userRepository->findAll();

        // Transform the data collection using the transformer
        $transformer = new UserTransformer();
        $resource = new Collection($userData, $transformer);
        $manager = new Manager();

        return $manager->createData($resource)->toArray();
    }
}