<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBarcodePlugin\Fixture\Factory;

use Sylius\Bundle\CoreBundle\Fixture\Factory\ProductExampleFactory as BaseProductExampleFactory;
use Sylius\Component\Core\Model\ProductInterface;

class ProductExampleFactory extends BaseProductExampleFactory
{
    use ProductExampleFactoryTrait;

    public function create(array $options = []): ProductInterface
    {
        $product = parent::create($options);

        $this->setRandomBarcodesToVariants($product);

        return $product;
    }
}
