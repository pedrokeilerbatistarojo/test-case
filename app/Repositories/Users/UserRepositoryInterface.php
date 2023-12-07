<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{
    /**
     * Save the user in the repository
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool;
}