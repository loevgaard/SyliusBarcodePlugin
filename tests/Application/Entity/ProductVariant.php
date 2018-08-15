<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Application\Entity;

use Loevgaard\SyliusBarcodePlugin\Entity\BarcodeAwareInterface;
use Loevgaard\SyliusBarcodePlugin\Entity\ProductVariantTrait;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

class ProductVariant extends BaseProductVariant implements BarcodeAwareInterface
{
    use ProductVariantTrait;
}
