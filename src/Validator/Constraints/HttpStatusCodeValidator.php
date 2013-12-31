<?php

namespace App\Validator\Constraints;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class HttpStatusCodeValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof HttpStatusCode) {
            throw new UnexpectedTypeException($constraint, HttpStatusCode::class);
        }

        if ($value === null) {
            return;
        }

        $validStatusCodes = array_keys(Response::$statusTexts);

        if (!in_array($value, $validStatusCodes, true)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', (string)$value)
                ->addViolation();
        }
    }
}
