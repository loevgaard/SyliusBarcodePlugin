<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Fixture;

use Sylius\Bundle\CoreBundle\Fixture\ProductFixture as BaseProductFixture;

class ProductFixture extends BaseProductFixture
{
    public function getName(): string
    {
        return 'loevgaard_sylius_barcode_product';
    }
}
