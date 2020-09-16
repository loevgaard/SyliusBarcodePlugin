<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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
