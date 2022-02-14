<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('loevgaard_sylius_barcode');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('require')
                            ->defaultFalse()
                            ->info('If true the barcode field will be required in the product forms (both product and variant)')
                        ->end()
                        ->booleanNode('require_valid')
                            ->defaultFalse()
                            ->info('If true the barcode field will be validated when entered in the product forms (both product and variant)')
                        ->end()
                        ->booleanNode('require_unique')
                            ->defaultTrue()
                            ->info('If true the barcode unique constraint will be added to the field')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
