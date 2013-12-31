<?php

namespace App\Controller\LogEntry;

use App\DTO\LogEntry\LogCountRequestTransfer;
use App\Exception\ValidationException;
use App\Repository\LogEntry\LogEntryRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoggerController extends BaseController
{
    /**
     * @throws ValidationException
     */
    #[Route('/count')]
    public function countAction(
        Request $request,
        LogEntryRepositoryInterface $logEntryRepository,
        ValidatorInterface $validator
    ): JsonResponse {

        $requestTransfer = (new LogCountRequestTransfer())->fromArray($request->query->all());

        $this->validateRequest($validator, $requestTransfer);

        $count = $logEntryRepository->countLogs($requestTransfer);

        return $this->json(['count' => $count]);
    }
}
