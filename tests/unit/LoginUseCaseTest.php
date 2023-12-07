<?php

namespace unit;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\UseCases\Auth\LoginUseCase;
use CodeIgniter\Test\CIUnitTestCase;
use Config\App;
use Config\Services;
use Tests\Support\Libraries\ConfigReader;

/**
 * @internal
 */
final class LoginUseCaseTest extends CIUnitTestCase
{
    public function testLogin()
    {
        // Mock UserRepository or create new instance of
        $userRepository = new UserRepository();

        // Instance LoginUseCase with UserRepository
        $loginUseCase = new LoginUseCase($userRepository);
        $user = $loginUseCase->execute('9999999999', 'password');

        $this->assertNotNull($user);
    }
}
