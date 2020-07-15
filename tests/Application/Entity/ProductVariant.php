<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantInterface as LoevgaardSyliusBarcodePluginProductVariantInterface;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantTrait as LoevgaardSyliusBarcodePluginProductVariantTrait;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant",
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="loevgaard_barcode_unique", columns={"barcode", "version"})
 *    }
 * )
 */
class ProductVariant extends BaseProductVariant implements LoevgaardSyliusBarcodePluginProductVariantInterface
{
    use LoevgaardSyliusBarcodePluginProductVariantTrait;
}
