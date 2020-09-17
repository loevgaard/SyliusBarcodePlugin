<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Fixture\Factory;

use Loevgaard\SyliusBarcodePlugin\Model\ProductVariantInterface as LoevgaardBarcodeProductVariantInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Webmozart\Assert\Assert;

trait ProductExampleFactoryTrait
{
    protected function setRandomBarcodesToVariants(ProductInterface $product): void
    {
        static $faker;

        if (null === $faker) {
            $faker = \Faker\Factory::create();
        }

        /** @var ProductVariantInterface|LoevgaardBarcodeProductVariantInterface $variant */
        foreach ($product->getVariants() as $variant) {
            Assert::isInstanceOf($variant, LoevgaardBarcodeProductVariantInterface::class);

            $variant->setBarcode($faker->ean13);
        }
    }
}
