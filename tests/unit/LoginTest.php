<?php

namespace unit;

use CodeIgniter\HTTP\Exceptions\RedirectException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestCase;
use CodeIgniter\Test\Filters\CITestStreamFilter;
use Config\App;
use Config\Services;
use ReflectionException;
use Tests\Support\Database\Seeds\UsersSeeder;
use Tests\Support\Libraries\ConfigReader;

/**
 * @internal
 */
final class LoginTest extends FeatureTestCase
{

    use DatabaseTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        CITestStreamFilter::$buffer = '';

        $this->setUpDatabase();
    }

    /**
     * @throws RedirectException
     * @throws ReflectionException
     */
    public function testLoginWithValidCredentials()
    {
        $this->seed(UsersSeeder::class);

        $response = $this->post('/auth/login', [
            'phone' => '9999999999',
            'password' => 'password',
        ]);

        $this->assertSame(200, $response->response->getStatusCode());

        $responseData = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('message', $responseData);
        $this->assertSame('Login successful', $responseData['message']);

        $this->assertArrayHasKey('token', $responseData);
        //$this->seeInDatabase('users', ['phone' => '9999999999']);
    }
}
