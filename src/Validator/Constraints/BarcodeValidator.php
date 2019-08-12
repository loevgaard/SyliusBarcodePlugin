<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BarcodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if ('' === $value || null === $value) {
            return;
        }

        $validator = new \violuke\Barcodes\BarcodeValidator($value);
        $valid = (bool) $validator->isValid();

        if (!$valid) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
