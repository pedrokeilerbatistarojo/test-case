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
     * @return string
     */
    public function execute(): string
    {
        $dompdf = new Dompdf();

        $data = ['users' => $this->userRepository->findAll()] ;

        $html = view('users/pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        $pdfPath = WRITEPATH . 'pdfs/' . uniqid('pdf_') . '.pdf';

        file_put_contents($pdfPath, $pdfContent);

        return base_url('pdfs/' . basename($pdfPath));
    }
}