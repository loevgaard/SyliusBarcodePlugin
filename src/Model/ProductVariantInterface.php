<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Model;

use Sylius\Component\Core\Model\ProductVariantInterface as BaseProductVariantInterface;

interface ProductVariantInterface extends BaseProductVariantInterface, BarcodeAwareInterface
{
}
