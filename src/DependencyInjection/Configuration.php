<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('loevgaard_sylius_barcode');
        $rootNode
            ->children()
                ->booleanNode('require_in_form')
                    ->defaultFalse()
                    ->info('If true the barcode field will be required in the product variant form')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
