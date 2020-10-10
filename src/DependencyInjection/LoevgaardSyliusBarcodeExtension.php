<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class LoevgaardSyliusBarcodeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $container->setParameter('loevgaard_sylius_barcode.form.require', $config['form']['require']);
        $container->setParameter('loevgaard_sylius_barcode.form.require_valid', $config['form']['require_valid']);
        $container->setParameter('loevgaard_sylius_barcode.form.require_unique', $config['form']['require_unique']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
