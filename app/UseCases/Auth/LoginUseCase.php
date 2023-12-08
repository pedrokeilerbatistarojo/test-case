<?php
namespace App\UseCases\Auth;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Services\Criteria\Users\FieldUserCriteria;
use Config\Services;
use Firebase\JWT\JWT;
use ReflectionException;

class LoginUseCase
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the login action use case
     * @param string $phone
     * @param string $password
     * @return string|null
     * @throws ReflectionException
     */
    public function execute(string $phone, string $password): ?string
    {
        $criteriaPhone = new FieldUserCriteria('phone', $phone);

        $users = $this->userRepository->search($criteriaPhone);

        // Process login information
        if (!empty($users)) {

            $user = reset($users);
            if (password_verify($password, $user->password)){

                //Update last login time
                $dateNow = new \DateTime();
                $this->userRepository->save([
                    'id' => $user->id,
                    'last_login' => $dateNow->format(DATE_TIME_FORMAT),
                ]);

                return $this->generate_jwt($user);
            }
        }

        return null;
    }

    /**
     * Generate Json Web Token
     * @param $user
     * @return string
     */
    public function generate_jwt($user): string
    {
        $key = Services::getSecretKey();
        $time = time();

        $payload = [
            'aud' => base_url(),
            'iat' => $time,
            'exp' => $time + 180,
            'data' => [
                'user_id' => $user->id,
                'phone' => $user->phone,
                'type'  => $user->type,
            ]
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
}