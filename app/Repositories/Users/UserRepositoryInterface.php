<?php

namespace App\Repositories\Users;

use App\Models\UserModel;
use App\Services\Criteria\CriteriaInterface;

interface UserRepositoryInterface
{
    /**
     * Save the user in the repository
     * @param array $data
     * @return array
     */
    public function save(array $data): array;

    /**
     * Search users by criteria
     * @param CriteriaInterface $criteria
     * @return array
     */
    public function search(CriteriaInterface $criteria): array;

    /**
     * Find users by id
     * @param $id
     */
    public function find($id);

    /**
     * Remove users by id
     * @param $id
     * @return bool
     */
    public function remove($id) : bool;

}