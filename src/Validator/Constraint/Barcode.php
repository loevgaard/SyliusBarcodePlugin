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
    public $message = 'loevgaard_sylius_barcode.product_variant.barcode.valid';

    public function validatedBy(): string
    {
        return 'loevgaard_sylius_barcode.validator.valid_barcode';
    }
}
