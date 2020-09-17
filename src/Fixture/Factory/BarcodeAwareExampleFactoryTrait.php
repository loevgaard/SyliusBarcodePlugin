<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Fixture\Factory;

use Loevgaard\SyliusBarcodePlugin\Model\BarcodeAwareInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * It can be used on some custom ProductVariantExampleFactory
 * (which Sylius don't have)
 */
trait BarcodeAwareExampleFactoryTrait
{
    protected function configureBarcodeOptions(OptionsResolver $resolver, int $chanceOfRandomBarcode = 90): void
    {
        $resolver
            ->setDefault('barcode', static function (): string {
                static $faker;

                if (null === $faker) {
                    $faker = \Faker\Factory::create();
                }

                return $faker->ean13;
            })
            ->setAllowedTypes('barcode', ['null', 'string'])
        ;
    }

    protected function setBarcodeField(BarcodeAwareInterface $barcodeAware, array $resolvedOptions = []): void
    {
        $barcodeAware->setBarcode($resolvedOptions['barcode']);
    }
}
