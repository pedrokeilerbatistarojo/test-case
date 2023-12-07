<?php

namespace App\Repositories\Users;

use App\Services\Criteria\CriteriaInterface;

interface UserRepositoryInterface
{
    /**
     * Save the user in the repository
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool;

    /**
     * Search users by criteria
     * @param CriteriaInterface $criteria
     * @return array
     */
    public function search(CriteriaInterface $criteria): array;

}