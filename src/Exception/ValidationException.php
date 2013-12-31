<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidationException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface $violations
     */
    private ConstraintViolationListInterface $violations;

    /**
     * @param ConstraintViolationListInterface $violations
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        ConstraintViolationListInterface $violations,
        string $message = "Validation Error",
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->violations = $violations;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
