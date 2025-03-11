<?php

declare(strict_types=1);

namespace Tests\Loevgaard\SyliusBarcodePlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;

final class ProductContext implements Context
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var ProductVariantResolverInterface */
    private $defaultVariantResolver;

    public function __construct(
        ObjectManager $objectManager,
        ProductVariantResolverInterface $defaultVariantResolver,
    ) {
        $this->objectManager = $objectManager;
        $this->defaultVariantResolver = $defaultVariantResolver;
    }

    /**
     * @Given :product has barcode :barcode
     * @Given /^(this product) has barcode "([^"]+)"$/
     * @Given :product has no barcode
     * @Given /^(this product) has no barcode$/
     */
    public function productHasBarcode(ProductInterface $product, ?string $barcode = null)
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $this->defaultVariantResolver->getVariant($product);
        $productVariant->setBarcode($barcode);

        $this->objectManager->flush();
    }
}
