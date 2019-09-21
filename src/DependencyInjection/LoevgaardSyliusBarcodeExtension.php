<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class LoevgaardSyliusBarcodeExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $container->setParameter('loevgaard_sylius_barcode.form.require', $config['form']['require']);
        $container->setParameter('loevgaard_sylius_barcode.form.require_valid', $config['form']['require_valid']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
