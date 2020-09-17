<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * It can be used on some custom ProductVariantFixture
 * (which Sylius don't have)
 */
trait BarcodeAwareFixtureTrait
{
    protected function configureChannelResourceNode(ArrayNodeDefinition $resourceNode): void
    {
        $resourceNode
            ->children()
                ->scalarNode('barcode')
        ;
    }
}
