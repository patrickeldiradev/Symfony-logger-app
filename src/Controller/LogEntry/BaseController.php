<?php

namespace App\Controller\LogEntry;

use App\DTO\AbstractTransfer;
use App\Exception\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseController extends AbstractController
{
    /**
     * @param ValidatorInterface $validator
     * @param AbstractTransfer $requestTransfer
     * @throws ValidationException
     */
    public function validateRequest(ValidatorInterface $validator, AbstractTransfer $requestTransfer): void
    {
        $errors = $validator->validate($requestTransfer);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
