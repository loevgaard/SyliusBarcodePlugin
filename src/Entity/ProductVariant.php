<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Entity;

use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

class ProductVariant extends BaseProductVariant implements BarcodeAwareInterface
{
    use ProductVariantTrait;
}
