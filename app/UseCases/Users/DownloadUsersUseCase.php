<?php

namespace App\UseCases\Users;

use App\Libraries\Redis\RedisService;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use App\Transformers\Users\UserTransformer;
use Config\Services;
use Dompdf\Dompdf;
use Exception;
use League\Fractal\Resource\Collection;
use League\Fractal\Manager;
use RedisException;

class DownloadUsersUseCase
{
    protected UserRepositoryInterface $userRepository;
    private RedisService $redisService;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->redisService = Services::getRedisServices();
    }

    /**
     * Execute the action download users
     * @return string
     * @throws Exception
     */
    public function execute(): string
    {
        $dompdf = new Dompdf();

        $data = $this->getUserData();
        $html = view('users/pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        $pdfPath = WRITEPATH . 'pdfs/' . uniqid('pdf_') . '.pdf';

        $parentDirectory = dirname($pdfPath);

        if (!file_exists($parentDirectory)) {
            if (!mkdir($parentDirectory, 0777, true)) {
                throw new Exception('Error creating directory');
            }
        }

        file_put_contents($pdfPath, $pdfContent);

        return base_url('pdfs/' . basename($pdfPath));
    }

    /**
     * @throws RedisException
     */
    private function getUserData(): array
    {
        $usersData = $this->redisService->get('users');

        if (!empty($usersData)){
            return ['users' => $usersData];
        }

        $usersData = $this->userRepository->findAll();
        $this->redisService->set('users', $usersData);

        return [
            'users' => $usersData
        ];
    }
}