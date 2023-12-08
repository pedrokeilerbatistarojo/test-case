<?php

namespace App\UseCases\Users;

use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Transformers\Users\UserTransformer;
use Dompdf\Dompdf;
use League\Fractal\Resource\Collection;
use League\Fractal\Manager;

class DownloadUsersUseCase
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the action download users
     * @return void
     */
    public function execute(): void
    {
        $userData = $this->userRepository->findAll();

        $dompdf = new Dompdf();
        $dompdf->loadHTML(
            view("users/pdf", $userData)
        );
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }
}