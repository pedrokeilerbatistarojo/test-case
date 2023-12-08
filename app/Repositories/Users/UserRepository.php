<?php

namespace App\Repositories\Users;

use App\Models\UserModel;
use App\Services\Criteria\CriteriaInterface;
use ReflectionException;

class UserRepository implements UserRepositoryInterface
{

    protected UserModel $user;
    public function __construct()
    {
        $this->user = new UserModel();
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

    /**
     * Find all users - limit defaults 20
     * @param int $limit
     * @return array
     */
    public function findAll(int $limit = 20)
    {
        return $this->user->findAll($limit);
    }

    /**
     * Find users by id
     * @param $id
     * @return array|object|null
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    /**
     * Remove users by id
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->user->delete($id);
    }
}