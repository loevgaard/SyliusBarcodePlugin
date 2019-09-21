<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Barcode extends Constraint
{
    /** @var string */
    public $message = 'The string "{{ string }}" is not a valid barcode.';

    public function validatedBy(): string
    {
        return 'loevgaard_sylius_barcode.validator.valid_barcode';
    }
}
