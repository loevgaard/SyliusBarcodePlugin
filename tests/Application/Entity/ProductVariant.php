<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantTrait;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
class ProductVariant extends BaseProductVariant implements BarcodeAwareInterface
{
    use ProductVariantTrait;
}
