<?php

namespace App\Repositories\Users;

use App\Models\User;
use ReflectionException;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Save or Update the user
     * @throws ReflectionException
     */
    public function save(array $data): bool
    {
        $user = new User();

        // Filter only allowed fields before filling out the model
        $filterData = array_intersect_key($data, array_flip($user->allowedFields));

        //Select the operation by id (Save or Update)
        if (isset($data['id'])){
            $result = $user->update($data['id'], $filterData);
        }else{
            $result = (bool)$user->insert($filterData);
        }

        return $result;

    }
}