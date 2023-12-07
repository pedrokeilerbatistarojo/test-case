<?php

namespace unit;

use CodeIgniter\Test\CIUnitTestCase;
use Config\App;
use Config\Services;
use LoginUseCase;
use Tests\Support\Libraries\ConfigReader;

/**
 * @internal
 */
final class LoginUseCaseTest extends CIUnitTestCase
{
    public function testLogin()
    {
        $loginUseCase = new LoginUseCase();
        $user = $loginUseCase->login('9191448604', 'password');

        $this->assertNotNull($user);
    }
}
