<?php

namespace App\Database\Seeds;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;
use Exception;
use Faker\Factory;
use Faker\Generator;
use ReflectionException;

class UsersSeeder extends Seeder
{
    protected UserRepositoryInterface $userRepository;
    protected Generator $faker;
    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        $this->userRepository = new UserRepository();
        $this->faker = Factory::create();
        parent::__construct($config, $db);
    }

    /**
     * Run seeder for users | Fake User Admin is 9999999999 - password
     *
     * @throws ReflectionException
     * @throws Exception
     */
    public function run()
    {
        $dateNow = new \DateTime();
        $arrTypes = ['admin', 'basic'];

        foreach ($arrTypes as $arrType) {
            $isAdmin = $this->isAdmin($arrType);
            $data = [
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->firstName(),
                'picture' => $this->faker->imageUrl(),
                'phone' => $isAdmin ? 9999999999 : random_int(1000000000, 9999999999),
                'email' => $this->faker->email(),
                'password' => 'password',
                'type' => $arrType,
                'created_at' => $dateNow->format('Y-m-d H:i:s'),
                'updated_at' => $dateNow->format('Y-m-d H:i:s'),
            ];

            $id = $this->userRepository->save($data);

            echo "User created with ID: $id\n";
        }
    }

    private function isAdmin(string $arrType): bool
    {
        return $arrType == 'admin';
    }
}