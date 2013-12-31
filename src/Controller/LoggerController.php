<?php

namespace App\Controller;

use App\DTO\LogCountRequestTransfer;
use App\Repository\LogEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use \DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoggerController extends AbstractController
{
    #[Route('/count')]
    public function countAction(Request $request, LogEntryRepository $logEntryRepository, ValidatorInterface $validator): JsonResponse
    {
        $requestTransfer = $this->getRequestTransfer($request);

        $errors = $validator->validate($requestTransfer);

        if (count($errors) > 0) {
            return $this->json(['errors' => (string)$errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $count = $logEntryRepository->countLogs($requestTransfer);

        return $this->json(['count' => $count]);
    }

    /**
     * @param Request $request
     * @return LogCountRequestTransfer
     */
    private function getRequestTransfer(Request $request)
    {
        $requestTransfer = new LogCountRequestTransfer();

        $serviceNames = isset($request->query->all()['serviceNames']) ? $request->query->all()['serviceNames'] : [];

        $requestTransfer->setServiceNames($serviceNames);


        if ($startDate = $request->query->get('startDate')) {
            $requestTransfer->setStartDate($startDate);
        }

        if ($endDate = $request->query->get('endDate')) {
            $requestTransfer->setEndDate($endDate);
        }

        $statusCode = $request->query->getInt('statusCode');
        $requestTransfer->setStatusCode($statusCode ?: null);

        return $requestTransfer;
    }
}