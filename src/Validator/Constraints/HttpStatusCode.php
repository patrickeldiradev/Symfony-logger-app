<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute] class HttpStatusCode extends Constraint
{
    public string $message = 'The status code must be a valid HTTP status code.';
}
