<?php

namespace Config;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Users\DeleteUserUseCase;
use App\UseCases\Users\DownloadUsersUseCase;
use App\UseCases\Users\StoreUserUseCase;
use App\UseCases\Users\ListUsersUseCase;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function getUserRepository(): UserRepositoryInterface
    {
        return new UserRepository();
    }
    public static function getLoginUseCase(): LoginUseCase
    {
        return new LoginUseCase(self::getUserRepository());
    }

    public static function getListUsersUseCase(): ListUsersUseCase
    {
        return new ListUsersUseCase(self::getUserRepository());
    }

    public static function getStoreUserUseCase(): StoreUserUseCase
    {
        return new StoreUserUseCase(self::getUserRepository());
    }

    public static function getDeleteUserUseCase(): DeleteUserUseCase
    {
        return new DeleteUserUseCase(self::getUserRepository());
    }

    public static function getDownloadUserUseCase(): DownloadUsersUseCase
    {
        return new DownloadUsersUseCase(self::getUserRepository());
    }

    public static function getServices()
    {
        return [
            // Otros servicios

            // Ejemplo de uso de clausura para LoginUseCase
            LoginUseCase::class => function ($config = null, $getShared = true) {
                return new LoginUseCase($config);
            },

            // Repositorios
            UserRepositoryInterface::class => UserRepository::class,
        ];
    }

    /**
     * Secret Key Example Test
     * @return string
     */
    public static function getSecretKey(): string
    {
        return 'secret_key_example_test';
    }
}
