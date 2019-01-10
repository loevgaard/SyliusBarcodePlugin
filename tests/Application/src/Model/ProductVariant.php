<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Application\src\Model;

use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantTrait;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

class ProductVariant extends BaseProductVariant implements BarcodeAwareInterface
{
    use ProductVariantTrait;
}
