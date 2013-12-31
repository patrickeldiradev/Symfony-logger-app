<?php

namespace App\Controller\LogEntry;

use App\DTO\LogEntry\LogCountRequestTransfer;
use App\Repository\LogEntry\LogEntryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoggerController extends AbstractController
{
    #[Route('/count')]
    public function countAction(
        Request $request,
        LogEntryRepositoryInterface $logEntryRepository,
        ValidatorInterface $validator
    ): JsonResponse {

        $requestTransfer = (new LogCountRequestTransfer())->fromArray($request->query->all());

        $errors = $validator->validate($requestTransfer);

        if (count($errors)) {
            return $this->json(['errors' => (string)$errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $count = $logEntryRepository->countLogs($requestTransfer);

        return $this->json(['count' => $count]);
    }
}
