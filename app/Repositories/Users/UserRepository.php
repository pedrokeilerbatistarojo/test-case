<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Services\Criteria\CriteriaInterface;
use ReflectionException;

class UserRepository implements UserRepositoryInterface
{

    protected User $user;
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Save or Update the user
     * @throws ReflectionException
     */
    public function save(array $data): bool
    {
        // Filter only allowed fields before filling out the model
        $filterData = array_intersect_key($data, array_flip($this->user->allowedFields));

        //Select the operation by id (Save or Update)
        if (isset($data['id'])){
            $result = $this->user->update($data['id'], $filterData);
        }else{
            $result = (bool)$this->user->insert($filterData);
        }

        return $result;

    }

    /**
     * Search users by their criteria
     * @param CriteriaInterface $criteria
     * @return array
     */
    public function search(CriteriaInterface $criteria): array
    {
        $builder = $this->user->builder();
        $criteria->apply($builder);

        return $builder->get()->getResult();
    }
}